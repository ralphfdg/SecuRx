// resources/js/admin.js

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Dismissable Success Alert
    const closeAlertBtn = document.getElementById('close-alert-btn');
    const alertBox = document.getElementById('success-alert');

    if (closeAlertBtn && alertBox) {
        closeAlertBtn.addEventListener('click', () => {
            alertBox.style.transition = 'opacity 0.3s ease';
            alertBox.style.opacity = '0';
            setTimeout(() => {
                alertBox.remove();
            }, 300);
        });
    }

    // 2. Simple form submit UX enhancement
    const adminMedForm = document.getElementById('admin-med-form');
    if(adminMedForm) {
        adminMedForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="opacity-75">Saving...</span>';
            submitBtn.classList.add('cursor-wait');
        });
    }

    // ==========================================
    // 3. DATASET PAGE: File Upload Name Display
    // ==========================================
    const dropzoneFile = document.getElementById('dropzone-file');
    if (dropzoneFile) {
        dropzoneFile.addEventListener('change', function(e) {
            const display = document.getElementById('file-name-display');
            if (e.target.files.length > 0) {
                display.textContent = 'Selected File: ' + e.target.files[0].name;
                display.classList.remove('hidden');
            } else {
                display.classList.add('hidden');
            }
        });
    }

    // ==========================================
    // 4. DATASET PAGE: Live Search DOM Replacement
    // ==========================================
    const searchInput = document.getElementById('live-search');
    if (searchInput) {
        let searchTimeout;
        const tableWrapper = document.getElementById('table-wrapper');
        const spinner = document.getElementById('search-spinner');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            spinner.classList.remove('hidden'); // Show loading spinner
            
            // Wait 400ms after the user stops typing to trigger the search
            searchTimeout = setTimeout(() => {
                const query = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);

                // Fetch the updated page silently in the background
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => response.text())
                    .then(html => {
                        // Extract just the table part from the new HTML
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTable = doc.getElementById('table-wrapper').innerHTML;
                        
                        // Replace the old table with the new one
                        tableWrapper.innerHTML = newTable;
                        spinner.classList.add('hidden'); // Hide spinner
                    })
                    .catch(() => {
                        spinner.classList.add('hidden');
                    });
            }, 400); 
        });
    }
});

// ==========================================
// 5. DATASET PAGE: Edit Modal Logic (Global Access)
// ==========================================
window.openEditModal = function(id, name, form, strength, price) {
    const modal = document.getElementById('edit-modal');
    if(!modal) return;

    document.getElementById('edit-name').value = name;
    document.getElementById('edit-form-input').value = form;
    document.getElementById('edit-strength').value = strength;
    document.getElementById('edit-price').value = price;
    
    // Dynamically set the form action URL to include the specific drug's ID
    document.getElementById('edit-form').action = `/admin/dataset/${id}`;
    
    modal.classList.remove('hidden');
};

window.closeEditModal = function() {
    const modal = document.getElementById('edit-modal');
    if(modal) modal.classList.add('hidden');
};

// ==========================================
// DATASET PAGE: Delete Modal Logic
// ==========================================
window.openDeleteModal = function(id, name) {
    const modal = document.getElementById('delete-modal');
    if(!modal) return;
    
    document.getElementById('delete-drug-name').textContent = name;
    document.getElementById('delete-form').action = `/admin/dataset/${id}`;
    
    modal.classList.remove('hidden');
};

window.closeDeleteModal = function() {
    const modal = document.getElementById('delete-modal');
    if(modal) modal.classList.add('hidden');
};

// ==========================================
// DATASET MANAGEMENT MODALS
// ==========================================

// Medication Handlers
window.openEditModal = function(id, name, form, strength, price) {
    document.getElementById('edit-form').action = `/admin/dataset/${id}`;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-form-input').value = form;
    document.getElementById('edit-strength').value = strength;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-modal').classList.remove('hidden');
};

window.closeEditModal = function() {
    document.getElementById('edit-modal').classList.add('hidden');
};

window.openDeleteModal = function(id, name) {
    document.getElementById('delete-form').action = `/admin/dataset/${id}`;
    document.getElementById('delete-drug-name').textContent = name;
    document.getElementById('delete-modal').classList.remove('hidden');
};

window.closeDeleteModal = function() {
    document.getElementById('delete-modal').classList.add('hidden');
};

// DPRI Handlers
window.openDpriEditModal = function(id, name, lowest, median, highest, year) {
    document.getElementById('edit-dpri-form').action = `/admin/dataset/dpri/${id}`;
    document.getElementById('edit-dpri-name').value = name;
    document.getElementById('edit-dpri-lowest').value = lowest;
    document.getElementById('edit-dpri-median').value = median;
    document.getElementById('edit-dpri-highest').value = highest;
    document.getElementById('edit-dpri-year').value = year;
    document.getElementById('edit-dpri-modal').classList.remove('hidden');
};

window.closeDpriEditModal = function() {
    document.getElementById('edit-dpri-modal').classList.add('hidden');
};

window.openDpriDeleteModal = function(id, name) {
    document.getElementById('delete-dpri-form').action = `/admin/dataset/dpri/${id}`;
    document.getElementById('delete-dpri-name').textContent = name;
    document.getElementById('delete-dpri-modal').classList.remove('hidden');
};

window.closeDpriDeleteModal = function() {
    document.getElementById('delete-dpri-modal').classList.add('hidden');
};