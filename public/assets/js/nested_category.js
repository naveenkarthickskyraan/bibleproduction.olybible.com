const baseUrl = '/admin/subcategories';
let currentTreeData = [];
let deleteNodeId = null;
let deleteModal = null;
let formModal = null;

// Key for sessionStorage
const TREE_STATE_KEY = 'subcategory_tree_state';

$(document).ready(function() {
    // Initialize modals
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    formModal = new bootstrap.Modal(document.getElementById('formModal'));

    // Reset form when modal closes
    $('#formModal').on('hidden.bs.modal', function() {
        resetForm();
    });

    renderTree();

    // Delete confirmation handler
    $('#confirmDelete').click(function() {
        if (deleteNodeId) {
            performDelete(deleteNodeId);
        }
    });

    // Image modal handlers
    const imageModal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const span = document.getElementsByClassName("close-image-modal")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        imageModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == imageModal) {
            imageModal.style.display = "none";
        }
    }
});

function resetForm() {
    $('#formType').val('');
    $('#nodeId').val('');
    $('#nodeName').val('');
    $('#nodeDescription').val('');
    $('#nodeImage').val('');
    $('#removeImage').prop('checked', false);
    $('#imagePreview').hide();
    $('#currentImageContainer').hide();
}

function renderTree() {
    showLoading();
    $.ajax({
        url: baseUrl,
        method: 'GET',
        success: function(data) {
            currentTreeData = data;
            if (data.length === 0) {
                $('#tree-container').html(`
                    <div class="empty-message">
                        <i class="fas fa-folder-open fa-2x mb-2"></i>
                        <p>No subcategories found. Start by adding a root category.</p>
                    </div>
                `);
            } else {
                $('#tree-container').html(renderNode(data));
                updateEmptyState();
                // Restore the tree state after rendering
                restoreTreeState();
            }
        },
        error: function(xhr) {
            showAlert('Error loading subcategories: ' + (xhr.responseJSON?.message || 'Unknown error'),
                'danger');
        }
    });
}

function renderNode(nodes, level = 0) {
    return nodes.map(node => {
        const hasChildren = Array.isArray(node.children) && node.children.length > 0;
        const imageUrl = node.image ? `/storage/${node.image}` : '';
        return `
            <div class="tree-node" id="node-${node.id}" data-level="${level}">
                <div class="tree-label ${hasChildren ? `expandable` : `leaf` }">
                    <div class="d-flex align-items-center">
                        ${hasChildren ?
                            `<span class="tree-toggle" onclick="toggleChildren(${node.id})">
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>` :
                            `<span class="tree-toggle" style="visibility: hidden;"><i class="fa-solid fa-angle-right"></i></span>`
                        }
                        <span class="node-name" data-id="${node.id}">
                            ${imageUrl ?
                                `<img src="${imageUrl}"
                                    style="width: 20px; height: 20px; object-fit: cover; margin-right: 5px; border-radius: 2px; cursor: pointer;"
                                    onclick="showImageModal('${imageUrl}')">` :
                                ''}
                            ${escapeHtml(node.name)}
                            ${hasChildren ? `<span class="badge-count">${countChildren(node.children)}</span>` : ''}
                        </span>
                        <input type="text" class="form-control edit-input" data-id="${node.id}"
                            value="${escapeHtml(node.name)}" onblur="updateNode(this)"
                            onkeydown="handleKeyPress(event, this)">
                    </div>
                    <div class="actions">
                        <button class="btn-action" onclick="event.stopPropagation(); openForm('add', ${node.id})">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        <button class="btn-action btn-edit" onclick="event.stopPropagation(); openEditForm(${node.id})">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn-action btn-delete" onclick="event.stopPropagation(); confirmDelete(${node.id})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
                ${hasChildren ?
                    `<div class="children" id="children-${node.id}" style="display: block;">
                            ${renderNode(node.children, level + 1)}
                        </div>` : ''
                }
            </div>
        `;
    }).join('');
}

function toggleChildren(id) {
    const childrenContainer = $(`#children-${id}`);
    const toggleIcon = $(`#node-${id} .tree-toggle i`);
    const isExpanded = childrenContainer.is(':visible');

    if (isExpanded) {
        childrenContainer.hide();
        toggleIcon.removeClass('fa-angle-down').addClass('fa-angle-right');
    } else {
        childrenContainer.show();
        toggleIcon.removeClass('fa-angle-right').addClass('fa-angle-down');
    }

    // Save the tree state
    saveTreeState(id, !isExpanded);
}

function saveTreeState(nodeId, isExpanded) {
    // Get current state from sessionStorage
    let treeState = {};
    try {
        treeState = JSON.parse(sessionStorage.getItem(TREE_STATE_KEY)) || {};
    } catch (e) {
        console.error('Error parsing tree state:', e);
    }

    // Update the state for this node
    treeState[nodeId] = isExpanded;

    // Save back to sessionStorage
    sessionStorage.setItem(TREE_STATE_KEY, JSON.stringify(treeState));
}

function restoreTreeState() {
    try {
        const treeState = JSON.parse(sessionStorage.getItem(TREE_STATE_KEY)) || {};

        // Apply the saved state to each node
        Object.keys(treeState).forEach(nodeId => {
            const childrenContainer = $(`#children-${nodeId}`);
            const toggleIcon = $(`#node-${nodeId} .tree-toggle i`);
            const shouldBeExpanded = treeState[nodeId];

            if (childrenContainer.length) {
                if (shouldBeExpanded) {
                    childrenContainer.show();
                    toggleIcon.removeClass('fa-angle-right').addClass('fa-angle-down');
                } else {
                    childrenContainer.hide();
                    toggleIcon.removeClass('fa-angle-down').addClass('fa-angle-right');
                }
            }
        });
    } catch (e) {
        console.error('Error restoring tree state:', e);
    }
}

function openEditForm(id) {
    showLoading();
    $.ajax({
        url: `${baseUrl}/${id}`,
        method: 'GET',
        success: function(subcategory) {
            $('#formType').val('edit');
            $('#nodeId').val(id);
            $('#nodeName').val(subcategory.name);
            $('#nodeDescription').val(subcategory.description || '');
            $('#nodeImage').val('');
            $('#removeImage').prop('checked', false);

            // Handle image preview and current image display
            $('#imagePreview').hide();
            $('#currentImageContainer').toggle(!!subcategory.image);

            if (subcategory.image) {
                $('#currentImage').attr('src', `/storage/${subcategory.image}`);
            }

            $('#formModalLabel').text("Edit Subcategory");
            formModal.show();
        },
        error: function(xhr) {
            showAlert('Error loading subcategory: ' + (xhr.responseJSON?.message || 'Unknown error'),
                'danger');
        }
    });
}

function showImageModal(imageUrl) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImg.src = imageUrl;
}

function openForm(type, parentId = null) {
    $('#formType').val(type);
    $('#nodeId').val(parentId || '');
    $('#nodeName').val('');
    $('#nodeDescription').val('');
    $('#nodeImage').val('');
    $('#removeImage').prop('checked', false);
    $('#imagePreview').hide();
    $('#currentImageContainer').hide();

    $('#formModalLabel').text(type === 'add' ?
        (parentId ? "Add Child Subcategory" : "Add Root Subcategory") :
        "Edit Subcategory");

    formModal.show();
}

function countChildren(children) {
    let count = children.length;
    children.forEach(child => {
        if (Array.isArray(child.children)) {
            count += countChildren(child.children);
        }
    });
    return count;
}

function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function editNodeName(element) {
    const $element = $(element);
    const $input = $element.siblings('.edit-input');

    $element.hide();
    $input.show().focus().select();
}

function handleKeyPress(event, input) {
    if (event.key === 'Enter') {
        updateNode(input);
    } else if (event.key === 'Escape') {
        const $input = $(input);
        $input.hide();
        $input.siblings('.node-name').show();
    }
}

function updateNode(input) {
    const $input = $(input);
    const id = $input.data('id');
    const newName = $input.val().trim();
    const $span = $input.siblings('.node-name');

    if (newName !== "") {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${baseUrl}/${id}`,
            method: 'PUT',
            data: {
                name: newName
            },
            success: function() {
                $span.text(newName);
                $span.show();
                $input.hide();
                showAlert(`Subcategory updated successfully!`, 'success');

                // Update the badge if it exists
                const $badge = $span.find('.badge-count');
                if ($badge.length) {
                    $span.append($badge);
                }
                renderTree();
            },
            error: function(xhr) {
                showAlert("Error updating subcategory name: " + (xhr.responseJSON?.message ||
                    'Unknown error'), 'danger');
                $span.show();
                $input.hide();
            }
        });
    } else {
        $span.show();
        $input.hide();
    }
}

function previewImage(input) {
    const file = input.files[0];
    const preview = document.getElementById('imagePreview');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

$('#saveNode').click(function() {
    const type = $('#formType').val();
    const id = $('#nodeId').val();
    const name = $('#nodeName').val().trim();
    const description = $('#nodeDescription').val().trim();
    const parentId = type === 'add' ? (id || null) : null;
    const removeImage = $('#removeImage').is(':checked');

    if (!name) {
        showAlert('Subcategory name is required', 'danger');
        return;
    }

    let formData = new FormData();
    formData.append('_method', type === 'add' ? 'POST' : 'PUT'); // For proper method spoofing
    formData.append('name', name);
    formData.append('description', description || ''); // Ensure empty string if null

    if (type === 'add') {
        formData.append('parent_id', parentId || ''); // Ensure empty string if null
    }

    if (removeImage) {
        formData.append('remove_image', '1');
    }

    const imageFile = $('#nodeImage')[0].files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    const url = type === 'add' ? baseUrl : `${baseUrl}/${id}`;
    const method = type === 'add' ? 'POST' : 'POST'; // Using POST with _method for consistency

    showLoading();
    $.ajax({
        url: url,
        method: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            renderTree();
            formModal.hide();
            showAlert(`Subcategory ${type === 'add' ? 'added' : 'updated'} successfully!`,
                'success');
        },
        error: function(xhr) {
            let errorMessage = `Error ${type === 'add' ? 'adding' : 'updating'} subcategory`;
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage += ': ' + xhr.responseJSON.error;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage += ': ' + Object.values(xhr.responseJSON.errors).join(' ');
            } else {
                errorMessage += ': Server error occurred';
            }
            showAlert(errorMessage, 'danger');
            console.error('Error details:', xhr.responseJSON);
        }
    });
});

function confirmDelete(id) {
    deleteNodeId = id;
    deleteModal.show();
}

function performDelete(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    showLoading();
    $.ajax({
        url: `${baseUrl}/${id}`,
        method: 'DELETE',
        success: function() {
            deleteModal.hide();
            renderTree();
            showAlert('Subcategory deleted successfully!', 'success');
        },
        error: function(xhr) {
            deleteModal.hide();
            showAlert('Error deleting subcategory: ' + (xhr.responseJSON?.message || 'Unknown error'),
                'danger');
        }
    });
}

function showAlert(message, type) {
    // Remove any existing alerts
    $('.alert').alert('close');

    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'} me-2"></i>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    $('.alert-container').append(alertHtml);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
}

function showLoading() {
    // You can implement a loading spinner here if needed
}

function updateEmptyState() {
    if ($('.tree-node').length === 0) {
        $('#tree-container').html(`
            <div class="empty-message">
                <i class="fas fa-folder-open fa-2x mb-2"></i>
                <p>No subcategories found matching your search.</p>
            </div>
        `);
    }
}

function searchTree() {
    const searchTerm = $('#searchInput').val().toLowerCase().trim();

    if (searchTerm === '') {
        $('.tree-node').show();
        $('.children').show();
        $('.tree-toggle i').removeClass('fa-angle-right').addClass('fa-angle-down');
        return;
    }

    $('.tree-node').each(function() {
        const nodeText = $(this).find('.node-name').text().toLowerCase();
        const hasMatch = nodeText.includes(searchTerm);
        $(this).toggle(hasMatch);

        // Show parents of matching nodes
        if (hasMatch) {
            $(this).parents('.children').show();
            $(this).parents('.children').prev('.tree-label').find('.tree-toggle i')
                .removeClass('fa-angle-right').addClass('fa-angle-down');
        }
    });
}
