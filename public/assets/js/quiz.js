const baseUrl = '/admin/subcategories';
let allNodes = [];
let savedCheckboxes = {}; // Store checkbox states

$(document).ready(function () {
    renderTree(); // Initial fetch of the tree
    $('#searchInput').on('input', filterTree); // Attach search event listener
});

function renderTree(searchQuery = '') {
    $.ajax({
        url: baseUrl,
        method: 'GET',
        data: { search: searchQuery }, // Send search term in AJAX request
        success: function (data) {
            allNodes = JSON.parse(JSON.stringify(data)); // Keep an unmodified copy

            if (!data || data.length === 0) {
                document.getElementById('tree-container').innerHTML = `<div class="empty-message">
                    <i class="fas fa-folder-open fa-2x mb-2"></i>
                    <p>No subcategories found. Start by adding a <a target="_blank" href="/admin/add_nested_category">root</a> category.</p>
                </div>`;
                return;
            }
            
            document.getElementById('tree-container').innerHTML = renderNode(data, searchQuery);
            restoreCheckboxStates(); // Restore checkboxes
        }
    });
}

function renderNode(nodes, searchQuery = '') {
    return nodes.map(node => {
        // Highlight matching text in node name
        const nodeName = highlightSearchTerm(node.name, searchQuery);

        return `<div class="tree-node" id="node-${node.id}">
                    <div class="tree-label ${Array.isArray(node.children) && node.children.length > 0 ? 'expandable' : 'leaf'}" style="display:flex;justify-content: space-between;">
                        <div class="d-flex align-items-center">
                            ${Array.isArray(node.children) && node.children.length > 0 ?
                                `<span class="tree-toggle" onclick="toggleChildren(${node.id})"><i class="fa-solid fa-angle-down"></i></span>` : ''
                            }
                            <label class="node-name" for="check-${node.id}" data-id="${node.id}">${nodeName}</label>
                        </div>
                        <div class="actions text-end float-end">
                            <div class="checkbox-container">
                                ${Array.isArray(node.children) && node.children.length === 0 ?
                                    `<input type="checkbox"
                                        ${!edit_category_id || edit_category_id.length === 0
                                            ? ''
                                            : (edit_category_id.length === 1 && node.id == edit_category_id[0]
                                                ? 'checked'
                                                : 'disabled')}
                                        name="category_id"
                                        class="node-checkbox"
                                        value="${node.id}"
                                        id="check-${node.id}"
                                        data-id="${node.id}"
                                        onchange="handleCheckboxChange(this)">` : ''
                                }
                            </div>
                        </div>
                    </div>
                    ${Array.isArray(node.children) && node.children.length > 0 ?
                        `<div class="children" id="children-${node.id}" style="display: block;">${renderNode(node.children, searchQuery)}</div>` : ''
                    }
                </div>`
    }).join('');
}

function highlightSearchTerm(text, searchTerm) {
    if (!searchTerm || !text) return text;

    const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
    return text.replace(regex, '<span class="highlight">$1</span>');
}

function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function toggleChildren(id) {
    const childrenContainer = document.getElementById(`children-${id}`);
    const toggleIcon = document.querySelector(`#node-${id} .tree-toggle`);
    if (childrenContainer.style.display === "none") {
        childrenContainer.style.display = "block";
        toggleIcon.innerHTML = '<i class="fa-solid fa-angle-down"></i>';
    } else {
        childrenContainer.style.display = "none";
        toggleIcon.innerHTML = '<i class="fa-solid fa-angle-right"></i>';
    }
}

function handleCheckboxChange(checkbox) {
    const checkboxes = document.querySelectorAll('.node-checkbox');

    // If the checkbox is checked, disable all other checkboxes
    if (checkbox.checked) {
        checkboxes.forEach(cb => {
            if (cb !== checkbox) {
                cb.disabled = true;
            }
        });
    } else {
        // If unchecked, enable all checkboxes
        checkboxes.forEach(cb => {
            cb.disabled = false;
        });
    }

    // Save checkbox state (Only save if checked)
    savedCheckboxes[checkbox.id] = checkbox.checked ? 'checked' : 'unchecked';
}

function restoreCheckboxStates() {
    document.querySelectorAll('.node-checkbox').forEach(checkbox => {
        if (savedCheckboxes[checkbox.id] === 'checked') {
            checkbox.checked = true;
            handleCheckboxChange(checkbox); // Disable others if checked
        }
    });
}

function filterTree() {
    const searchQuery = $('#searchInput').val().toLowerCase();
    renderTree(searchQuery); // Fetch updated data based on search
}


//Questions selection process js is there


function showImageModal(imageUrl) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImg.src = imageUrl;
}
