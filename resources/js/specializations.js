// LIVE SEARCH LOGIC
document.addEventListener('DOMContentLoaded', function() {
    let searchTimer;
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');

    if (searchInput) {
        // Restore focus and cursor position after the page reloads
        if (searchInput.value.length > 0) {
            const val = searchInput.value;
            searchInput.focus();
            searchInput.value = '';
            searchInput.value = val;
        }

        // Listen for keystrokes
        searchInput.addEventListener('keyup', function(e) {
            // Ignore structural keys like tabs, shifts, and arrows to prevent unnecessary reloads
            const ignoreKeys = ['Tab', 'Shift', 'Control', 'Alt', 'ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'];
            if (ignoreKeys.includes(e.key)) return;

            // Clear the previous timer if the user is still typing
            clearTimeout(searchTimer);
            
            // Set a 500ms delay before submitting to prevent spamming the server
            searchTimer = setTimeout(() => {
                searchForm.submit();
            }, 500); 
        });
    }
});

// MODAL HANDLERS (Exported to global window object)
window.openAddSpecModal = function() { 
    document.getElementById('add-spec-modal').classList.remove('hidden'); 
};
window.closeAddSpecModal = function() { 
    document.getElementById('add-spec-modal').classList.add('hidden'); 
};

window.openEditSpecModal = function(id, name, desc) {
    document.getElementById('edit-spec-form').action = `/admin/specializations/${id}`;
    document.getElementById('edit-spec-name').value = name;
    document.getElementById('edit-spec-desc').value = desc;
    document.getElementById('edit-spec-modal').classList.remove('hidden');
};
window.closeEditSpecModal = function() { 
    document.getElementById('edit-spec-modal').classList.add('hidden'); 
};

window.openDeleteSpecModal = function(id, name) {
    document.getElementById('delete-spec-form').action = `/admin/specializations/${id}`;
    document.getElementById('delete-spec-name').textContent = name;
    document.getElementById('delete-spec-modal').classList.remove('hidden');
};
window.closeDeleteSpecModal = function() { 
    document.getElementById('delete-spec-modal').classList.add('hidden'); 
};