const baseUrl = '/admin/subcategories';
const batchesApiUrl = '/admin/batches';
let allNodes = [];
let selectedNodes = new Set();
let currentSelection = {
    selectedTree: null,
    startingPoint: null
};
let batchItems = [];

$(document).ready(function () {
    fetchAndRenderTree();
    loadSavedBatches();
    addConfirmationModal();
    $('#searchInput').on('input', filterTree);
    $('#resetSelectionBtn').on('click', resetCurrentSelection);
    $('#addToBatchBtn').on('click', addCurrentSelectionToBatch);
    $('#saveBatchBtn').on('click', function() {
        if (batchItems.length === 0) {
            showTemporaryAlert('No items in batch to save', 'warning');
            return;
        }
        const modal = new bootstrap.Modal(document.getElementById('batchConfirmationModal'));
        const isEditing = batchItems.some(item => item.id);
        $('#batchConfirmationBody').html(
            isEditing
                ? 'Are you sure you want to update this batch? This will overwrite the existing batch.'
                : 'Are you sure you want to save this batch?'
        );
        $('#confirmBatchAction').off('click').on('click', function() {
            modal.hide();
            saveBatchToDatabase();
        });
        modal.show();
    });
});

function fetchAndRenderTree(searchQuery = '') {
    $.ajax({
        url: baseUrl,
        method: 'GET',
        data: { search: searchQuery },
        success: function (data) {
            allNodes = JSON.parse(JSON.stringify(data));

            if (!data || data.length === 0) {
                document.getElementById('tree-container').innerHTML = `<div class="message-container"><div class="empty-message text-center">
                        <i class="fas fa-folder-open fa-2x mb-2"></i>
                        <p>No subcategories found. Start by adding a <a target="_blank" href="/admin/add_nested_category">root</a> category.</p>
                    </div>
                </div>`;
                return;
            }

            document.getElementById('tree-container').innerHTML = renderNode(data);
            updateUIBasedOnCurrentSelection();
            updateSelectedCount();
        },
        error: function (error) {
            console.error("Error fetching subcategories:", error);
            document.getElementById('tree-container').innerHTML =
                '<div class="message-container">Error loading subcategories. Please try again.</div>';
        }
    });
}

function renderNode(nodes, parentId = null) {
    return nodes.map(node => {
        const hasChildren = Array.isArray(node.children) && node.children.length > 0;
        const isSelected = selectedNodes.has(node.id);
        const isCurrentTree = currentSelection.selectedTree && currentSelection.selectedTree.id === node.id;
        const isStartingPoint = currentSelection.startingPoint && currentSelection.startingPoint.id === node.id;

        return `
        <div class="tree-node ${isCurrentTree ? 'node-selected' : ''} ${isStartingPoint ? 'node-starting-point' : ''}"
            id="node-${node.id}" data-name="${node.name}" data-id="${node.id}" data-parent-id="${parentId}">
            <div class="tree-label ${hasChildren ? 'expandable' : 'leaf'}" style="display:flex;justify-content: space-between;">
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="node-checkbox" id="checkbox-${node.id}"
                        data-id="${node.id}"
                        ${isSelected ? 'checked' : ''}
                        onchange="handleCheckboxChange(this, ${node.id}, ${hasChildren})">

                    ${hasChildren ?
                        `<span class="tree-toggle" onclick="toggleChildren(${node.id})"><i class="fa-solid fa-angle-down"></i></span>` : ''
                    }
                    <span class="node-name" data-id="${node.id}">${node.name}</span>
                    <span class="selected-indicator">
                        <i class="fas fa-check"></i> Selected
                    </span>
                </div>
                <div class="actions text-end float-end">
                    <div class="d-flex align-items-center">
                        <span class="batch-add-status" id="status-${node.id}" style="display: none;"></span>
                        <button class="btn btn-sm btn-outline-primary select-tree-btn ${isCurrentTree ? 'selected' : ''}"
                            data-id="${node.id}"
                            data-name="${node.name}"
                            onclick="selectTree(${node.id}, '${node.name}')">
                            <i class="fas ${isCurrentTree ? 'fa-check-circle' : 'fa-check'} me-1"></i>
                            ${isCurrentTree ? 'Selected' : 'Select'}
                        </button>
                        <button class="btn btn-sm btn-outline-warning ms-1 start-from-btn"
                            data-id="${node.id}"
                            data-name="${node.name}"
                            onclick="setStartingPoint(${node.id}, '${node.name}')">
                            <i class="fas fa-flag me-1"></i> Start From
                        </button>
                    </div>
                </div>
            </div>
            ${hasChildren ?
                `<div class="children" id="children-${node.id}" style="display: block;">${renderNode(node.children, node.id)}</div>` : ''
            }
        </div>`;
    }).join('');
}

function toggleChildren(id) {
    const childrenContainer = document.getElementById(`children-${id}`);
    const toggleIcon = document.querySelector(`#node-${id} .tree-toggle i`);

    if (childrenContainer.style.display === "none") {
        childrenContainer.style.display = "block";
        toggleIcon.className = "fa-solid fa-angle-down";
    } else {
        childrenContainer.style.display = "none";
        toggleIcon.className = "fa-solid fa-angle-right";
    }
}

function handleCheckboxChange(checkbox, id, hasChildren) {
    if (checkbox.checked) {
        selectedNodes.add(parseInt(id));

        // If the node has children, select all of them
        if (hasChildren) {
            selectAllChildren(id);
        }

        // Check if all siblings are selected, then select the parent
        selectParentsIfAllSiblingsSelected(id);
    } else {
        selectedNodes.delete(parseInt(id));

        // If the node has children, unselect all of them
        if (hasChildren) {
            unselectAllChildren(id);
        }

        // Reset selection only if nothing is selected
        if (selectedNodes.size === 0) {
            resetCurrentSelection();
        }
    }

    // ✅ Update checkbox states visually
    updateCheckboxStates();

    // ✅ Update the count of selected nodes
    updateSelectedCount();
}


function selectAllChildren(parentId) {
    const childrenContainer = document.getElementById(`children-${parentId}`);
    if (!childrenContainer) return;
    const childNodes = childrenContainer.querySelectorAll('.tree-node');

    childNodes.forEach(childNode => {
        const childId = childNode.dataset.id;
        selectedNodes.add(parseInt(childId));

        const childCheckbox = document.getElementById(`checkbox-${childId}`);
        if (childCheckbox && childCheckbox.dataset.hasChildren === "true") {
            selectAllChildren(childId);
        }
    });
}

function unselectAllChildren(parentId) {
    const childrenContainer = document.getElementById(`children-${parentId}`);
    if (!childrenContainer) return;

    const childNodes = childrenContainer.querySelectorAll('.tree-node');

    childNodes.forEach(childNode => {
        const childId = childNode.dataset.id;
        selectedNodes.delete(parseInt(childId));

        const childCheckbox = document.getElementById(`checkbox-${childId}`);
        if (childCheckbox) {
            childCheckbox.checked = false;
        }

        unselectAllChildren(childId);
    });
}

function selectParentsIfAllSiblingsSelected(id) {
    const nodeElement = document.getElementById(`node-${id}`);
    if (!nodeElement) return;

    const parentId = nodeElement.dataset.parentId;
    if (!parentId) return;

    const parentElement = document.getElementById(`node-${parentId}`);
    if (!parentElement) return;

    const siblingsContainer = parentElement.querySelector('.children');
    if (!siblingsContainer) return;

    const siblingNodes = siblingsContainer.querySelectorAll('.tree-node');
    let allSiblingsSelected = true;

    siblingNodes.forEach(sibling => {
        const siblingId = sibling.dataset.id;
        if (!selectedNodes.has(parseInt(siblingId))) {
            allSiblingsSelected = false;
        }
    });

    if (allSiblingsSelected) {
        selectedNodes.add(parseInt(parentId));
        selectParentsIfAllSiblingsSelected(parentId);
    }
}

function updateCheckboxStates() {
    document.querySelectorAll('.node-checkbox').forEach(checkbox => {
        const id = parseInt(checkbox.dataset.id);
        checkbox.checked = selectedNodes.has(id);
    });
}

function updateSelectedCount() {
    document.getElementById('selectedCount').textContent = `${selectedNodes.size} selected`;
}

function selectTree(id, name) {
    // If a tree is already selected and it's the same tree, do nothing
    if (currentSelection.selectedTree && currentSelection.selectedTree.id === id) {
        return;
    }

    // Reset current selection if selecting a different tree
    resetCurrentSelection();

    currentSelection.selectedTree = {
        id: id,
        name: name
    };

    // Clear previously selected nodes
    selectedNodes.clear();
    updateCheckboxStates();
    updateSelectedCount();

    updateUIBasedOnCurrentSelection();

    document.getElementById('selection-status').innerHTML = `Tree "<strong>${name}</strong>" selected. Now please select a starting point.`;

    fetchAndRenderTree($('#searchInput').val());
}

function setStartingPoint(id, name) {
    const nodeId = parseInt(id);

    // If clicking the already selected starting point, deselect it
    if (currentSelection.startingPoint && currentSelection.startingPoint.id === nodeId) {
        currentSelection.startingPoint = null;
        updateUIBasedOnCurrentSelection();
        // updatePreview();
        $('#updateBatchBtn').prop('disabled', true);
        document.getElementById('selection-status').innerHTML =
            `Tree "<strong>${currentSelection.selectedTree.name}</strong>" selected. Please select a starting point.`;
        return;
    }

    // Validate selection
    if (!currentSelection.selectedTree) {
        showTemporaryAlert('Please select a tree first before setting a starting point', 'danger');
        return;
    }

    // Check if starting point is within the selected tree
    let currentNode = document.getElementById(`node-${nodeId}`);
    let isInSelectedTree = false;

    while (currentNode) {
        if (parseInt(currentNode.dataset.id) === currentSelection.selectedTree.id) {
            isInSelectedTree = true;
            break;
        }
        currentNode = document.getElementById(`node-${currentNode.dataset.parentId}`);
    }

    if (!isInSelectedTree) {
        showTemporaryAlert('Starting point must be within the selected tree', 'danger');
        return;
    }

    // Update starting point
    currentSelection.startingPoint = { id: nodeId, name: name };

    // Auto-select the starting point node and all its descendants
    selectedNodes.add(nodeId);
    const checkbox = document.getElementById(`checkbox-${nodeId}`);
    if (checkbox) checkbox.checked = false;

    // Select all children of the starting point
    const childrenContainer = document.getElementById(`children-${nodeId}`);
    if (childrenContainer) {
        const childNodes = childrenContainer.querySelectorAll('.tree-node');
        childNodes.forEach(childNode => {
            const childId = parseInt(childNode.dataset.id);
            selectedNodes.add(childId);
            const childCheckbox = document.getElementById(`checkbox-${childId}`);
            if (childCheckbox) childCheckbox.checked = true;

            // Recursively select all descendants
            if (childNode.querySelector('.children')) {
                selectAllChildren(childId);
            }
        });
    }

    // Update UI
    updateUIBasedOnCurrentSelection();
    updateCheckboxStates();
    updateSelectedCount();

    document.getElementById('addToBatchBtn').disabled = false;
    // Update status message
    document.getElementById('selection-status').innerHTML =
        `Ready to update: Tree "<strong>${currentSelection.selectedTree.name}</strong>" with starting point "<strong>${name}</strong>"`;

    // Update preview
    // updatePreview();

    // Auto-validate
    // validateSelection();
}

function updateUIBasedOnCurrentSelection() {
    document.querySelectorAll('.tree-node').forEach(node => {
        node.classList.remove('node-selected', 'node-starting-point');
    });

    document.querySelectorAll('.select-tree-btn').forEach(btn => {
        btn.classList.remove('selected');
        btn.innerHTML = `<i class="fas fa-check me-1"></i> Select`;
    });

    document.querySelectorAll('.batch-add-status').forEach(status => {
        status.style.display = 'none';
    });

    if (currentSelection.selectedTree) {
        const selectedNode = document.getElementById(`node-${currentSelection.selectedTree.id}`);
        if (selectedNode) {
            selectedNode.classList.add('node-selected');

            const selectBtn = selectedNode.querySelector('.select-tree-btn');
            if (selectBtn) {
                selectBtn.classList.add('selected');
                selectBtn.innerHTML = `<i class="fas fa-check-circle me-1"></i> Selected`;
            }

            const statusEl = document.getElementById(`status-${currentSelection.selectedTree.id}`);
            if (statusEl) {
                statusEl.textContent = 'Selected';
                statusEl.className = 'batch-add-status status-selected';
                statusEl.style.display = 'inline-block';
            }
        }
    }

    if (currentSelection.startingPoint) {
        const startingNode = document.getElementById(`node-${currentSelection.startingPoint.id}`);
        if (startingNode) {
            startingNode.classList.add('node-starting-point');

            const statusEl = document.getElementById(`status-${currentSelection.startingPoint.id}`);
            if (statusEl) {
                statusEl.textContent = 'Start From';
                statusEl.className = 'batch-add-status status-start-from';
                statusEl.style.display = 'inline-block';
            }
        }
    }

    updateCurrentSelectionInfo();
}

function updateCurrentSelectionInfo() {
    const infoElement = document.getElementById('current-selection');

    if (!currentSelection.selectedTree) {
        infoElement.innerHTML = '<div class="text-muted">No selection in progress</div>';
        return;
    }

    let infoHTML = `
        <table class="selection-info-table">
            <tr>
                <th>Selected Tree</th>
                <td>${currentSelection.selectedTree.name}</td>
            </tr>
            <tr>
                <th>Starting Point</th>
                <td>${currentSelection.startingPoint ?
                    currentSelection.startingPoint.name :
                    '<span class="text-danger">Not specified</span>'}
                </td>
            </tr>
            <tr>
                <th>Selected Nodes</th>
                <td>${selectedNodes.size} nodes selected</td>
            </tr>
        </table>
    `;

    infoElement.innerHTML = infoHTML;
}

function resetCurrentSelection() {
    currentSelection = {
        selectedTree: null,
        startingPoint: null
    };

    // Clear selected nodes
    selectedNodes.clear();
    updateCheckboxStates();
    updateSelectedCount();

    updateUIBasedOnCurrentSelection();

    document.getElementById('addToBatchBtn').disabled = true;

    document.getElementById('selection-status').innerHTML = 'Please select a tree first.';

    // Reset search input and re-render tree
    $('#searchInput').val('');
    fetchAndRenderTree();
}

function addCurrentSelectionToBatch() {
    if (!currentSelection.selectedTree || !currentSelection.startingPoint) {
        showTemporaryAlert('Both a tree and starting point must be selected', 'danger');
        return;
    }

    if (selectedNodes.size === 0) {
        showTemporaryAlert('Please select at least one node', 'warning');
        return;
    }

    const selectedNodeDetails = [];
    selectedNodes.forEach(id => {
        const nodeElement = document.getElementById(`node-${id}`);
        if (nodeElement) {
            selectedNodeDetails.push({
                id: id,
                name: nodeElement.dataset.name,
                parentId: nodeElement.dataset.parentId ? parseInt(nodeElement.dataset.parentId) : null
            });
        }
    });

    batchItems.push({
        tree: currentSelection.selectedTree,
        startingPoint: currentSelection.startingPoint,
        selectedNodes: selectedNodeDetails,
        orderIndex: batchItems.length
    });

    showTemporaryAlert('Added to batch successfully!', 'success');

    resetCurrentSelection();
    selectedNodes.clear();
    updateSelectedCount();
    updateCheckboxStates();

    updateBatchDisplay();
}

function updateBatchDisplay() {
    const batchListElement = document.getElementById('batch-list');
    const batchCountElement = document.getElementById('batch-count');

    batchCountElement.textContent = `${batchItems.length} item${batchItems.length !== 1 ? 's' : ''}`;

    document.getElementById('saveBatchBtn').disabled = batchItems.length === 0;

    if (batchItems.length === 0) {
        batchListElement.innerHTML = '<div class="text-center py-3 text-muted">No items in batch</div>';
        return;
    }

    let batchHTML = '';

    batchItems.forEach((item, index) => {
        batchHTML += `
            <div class="batch-list-item">
                <div>
                    <div><strong>#${index + 1}:</strong> ${item.tree.name}</div>
                    <div class="start-from">
                        Start from: <span class="start-from-highlight">${item.startingPoint.name}</span>
                    </div>
                    <div class="start-from">
                        Nodes: <span class="start-from-highlight">${item.selectedNodes.length} selected</span>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-danger" onclick="removeFromBatch(${index})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    });

    batchListElement.innerHTML = batchHTML;
}

function removeFromBatch(index) {
    batchItems.splice(index, 1);

    batchItems.forEach((item, idx) => {
        item.orderIndex = idx;
    });

    updateBatchDisplay();
}


function saveBatchToDatabase() {
    if (batchItems.length === 0) {
        showTemporaryAlert('No items in batch to save', 'warning');
        return;
    }

    var app_name = $('#app_name').val();
    if (!app_name) {
        showTemporaryAlert('Please enter an app name', 'warning');
        return;
    }
    

    const dataToSave = {
        app_name: app_name,
        batches: batchItems.map(item => ({
            tree_id: item.tree.id,
            tree_name: item.tree.name,
            starting_point_id: item.startingPoint.id,
            starting_point_name: item.startingPoint.name,
            selected_nodes: item.selectedNodes.map(node => ({
                node_id: node.id,
                node_name: node.name,
                parent_id: node.parentId
            })),
            selection_order: item.orderIndex + 1
        }))
    };

    $.ajax({
        url: batchesApiUrl,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: dataToSave,
        success: function(response) {
            showTemporaryAlert('Batch saved successfully!', 'success');
            batchItems = [];
            updateBatchDisplay();
            loadSavedBatches(); // Reload the saved batches after saving
        },
        error: function(error) {
            // Handle error response
            if (error.responseJSON && error.responseJSON.message) {
                showTemporaryAlert(error.responseJSON.message, 'danger');  
            } else {
                showTemporaryAlert('Error saving batch. Please try again.', 'danger');
            }
        }
    });
}




function loadSavedBatches() {
    $.ajax({
        url: batchesApiUrl,
        method: 'GET',
        success: function(response) {
            renderSavedBatches(response.data);
        },
        error: function(error) {
            console.error("Error loading saved batches:", error);
            $('#saved-batches-container').html(
                '<div class="text-center py-3 text-danger">Error loading saved batches</div>'
            );
        }
    });
}

function renderSavedBatches(batches) {
    const container = $('#saved-batches-container');

    if (!batches || batches.length === 0) {
        container.html('<div class="text-center py-3 text-muted">No saved batches found</div>');
        return;
    }

    let html = '';

    batches.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    batches.forEach(batch => {
        const selectedNodes = typeof batch.selected_nodes === 'string'
            ? JSON.parse(batch.selected_nodes)
            : batch.selected_nodes;

        html += `
            <div class="saved-batch-card" data-batch-id="${batch.id}">
                <div class="saved-batch-header">
                    <span>${batch.tree_name}</span>
                    <span class="badge bg-secondary">${new Date(batch.created_at).toLocaleString()}</span>
                </div>
                <div class="saved-batch-details">
                    <div>Starting Point: <strong>${batch.starting_point_name}</strong></div>
                    <div>Nodes Selected: <strong>${selectedNodes.length}</strong></div>
                </div>
                <div class="saved-batch-nodes">
                    ${selectedNodes.slice(0, 5).map(node =>
                        `<span class="node-item">${node.node_name}</span>`
                    ).join('')}
                    ${selectedNodes.length > 5 ?
                        `<span class="node-item">+${selectedNodes.length - 5} more</span>` : ''}
                </div>
                <div class="mt-2 d-flex justify-content-between">
                    <button class="btn btn-sm btn-outline-primary load-batch-btn"
                        onclick="loadBatchForEditing(${batch.id})">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger delete-batch-btn"
                        onclick="deleteBatch(${batch.id})">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        `;
    });

    container.html(html);
}

function loadBatchForEditing(batchId) {
    $.ajax({
        url: `${batchesApiUrl}/${batchId}`,
        method: 'GET',
        success: function(response) {
            const batch = response.data;
            const selectedNodesData = typeof batch.selected_nodes === 'string'
                ? JSON.parse(batch.selected_nodes)
                : batch.selected_nodes;

            batchItems = [{
                id: batch.id,
                tree: {
                    id: batch.tree_id,
                    name: batch.tree_name
                },
                startingPoint: {
                    id: batch.starting_point_id,
                    name: batch.starting_point_name
                },
                selectedNodes: selectedNodesData.map(node => ({
                    id: node.node_id,
                    name: node.node_name,
                    parentId: node.parent_id || null
                })),
                orderIndex: 0
            }];

            updateBatchDisplay();

            selectedNodes = new Set();

            currentSelection = {
                selectedTree: {
                    id: batch.tree_id,
                    name: batch.tree_name
                },
                startingPoint: {
                    id: batch.starting_point_id,
                    name: batch.starting_point_name
                }
            };

            selectedNodesData.forEach(node => {
                selectedNodes.add(parseInt(node.node_id));
            });

            updateUIBasedOnCurrentSelection();
            updateCheckboxStates();
            updateSelectedCount();

            document.getElementById('addToBatchBtn').disabled = false;

            document.getElementById('tree-container').scrollIntoView({
                behavior: 'smooth'
            });

            showTemporaryAlert('Batch loaded for editing. You can modify and save it again.', 'info');

            fetchAndRenderTree($('#searchInput').val());
        },
        error: function(error) {
            console.error("Error loading batch:", error);
            showTemporaryAlert('Error loading batch for editing', 'danger');
        }
    });
}


function addConfirmationModal() {
    const modalHTML = `
    <div class="modal fade" id="batchConfirmationModal" tabindex="-1" aria-labelledby="batchConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchConfirmationModalLabel">Confirm Batch Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="batchConfirmationBody">
                    Are you sure you want to save this batch?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmBatchAction">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    `;

    $('body').append(modalHTML);
}



function deleteBatch(batchId) {
    if (!confirm('Are you sure you want to delete this batch?')) {
        return;
    }

    $.ajax({
        url: `${batchesApiUrl}/${batchId}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            showTemporaryAlert('Batch deleted successfully', 'success');
            loadSavedBatches();
        },
        error: function(error) {
            console.error("Error deleting batch:", error);
            showTemporaryAlert('Error deleting batch', 'danger');
        }
    });
}
function showTemporaryAlert(message, type) {
    // Create the alert container if it doesn't exist
    let alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) {
        alertContainer = document.createElement('div');
        alertContainer.className = 'alert-container position-fixed bottom-0 end-0 m-3';
        alertContainer.style.zIndex = '9999';
        document.body.appendChild(alertContainer);
    }

    // Remove any existing alerts inside the container
    alertContainer.innerHTML = '';

    // Create the alert element
    const alertElement = document.createElement('div');
    alertElement.className = `alert alert-${type} alert-dismissible fade show`;
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Append to alert container
    alertContainer.appendChild(alertElement);

    // Auto-remove the alert after 3 seconds
    setTimeout(() => {
        alertElement.classList.remove('show');
        setTimeout(() => {
            alertElement.remove();

            // Optional: clean up empty container
            if (alertContainer.children.length === 0) {
                alertContainer.remove();
            }

        }, 150);
    }, 1000);
}


function filterTree() {
    const searchQuery = $('#searchInput').val().toLowerCase();
    fetchAndRenderTree(searchQuery);
}