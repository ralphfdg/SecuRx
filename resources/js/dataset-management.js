// Tab Switching Logic
window.switchTab = function(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('border-securx-cyan', 'border-blue-500', 'text-securx-navy', 'text-blue-900');
        btn.classList.add('border-transparent', 'text-gray-500');
    });

    document.getElementById(tabId).classList.remove('hidden');
    
    const activeBtn = document.getElementById('btn-' + tabId);
    if(tabId === 'med-tab') {
        activeBtn.classList.remove('border-transparent', 'text-gray-500');
        activeBtn.classList.add('border-securx-cyan', 'text-securx-navy');
    } else {
        activeBtn.classList.remove('border-transparent', 'text-gray-500');
        activeBtn.classList.add('border-blue-500', 'text-blue-900');
    }

    sessionStorage.setItem('activeDatasetTab', tabId);
};

document.addEventListener('DOMContentLoaded', () => {
    // Automatically open the DPRI tab if returning from a DPRI search or pagination
    const urlParams = new URLSearchParams(window.location.search);
    let savedTab = sessionStorage.getItem('activeDatasetTab') || 'med-tab';
    
    if(urlParams.has('dpri_page') || urlParams.get('active_tab') === 'dpri-tab') {
        savedTab = 'dpri-tab';
    }
    
    window.switchTab(savedTab);

    // ==========================================
    // DPRI Auto-Compute Median Price
    // ==========================================
    const lowestInput = document.getElementById('edit-dpri-lowest');
    const highestInput = document.getElementById('edit-dpri-highest');
    const medianInput = document.getElementById('edit-dpri-median');

    function calculateMedian() {
        const lowest = parseFloat(lowestInput.value) || 0;
        const highest = parseFloat(highestInput.value) || 0;

        if (lowestInput.value !== '' && highestInput.value !== '') {
            const median = (lowest + highest) / 2;
            medianInput.value = median.toFixed(2); 
        }
    }

    if (lowestInput && highestInput) {
        lowestInput.addEventListener('input', calculateMedian);
        highestInput.addEventListener('input', calculateMedian);
    }
});

// Import Modals
window.openImportMedModal = function() { document.getElementById('import-med-modal').classList.remove('hidden'); };
window.closeImportMedModal = function() { document.getElementById('import-med-modal').classList.add('hidden'); };
window.openImportDpriModal = function() { document.getElementById('import-dpri-modal').classList.remove('hidden'); };
window.closeImportDpriModal = function() { document.getElementById('import-dpri-modal').classList.add('hidden'); };

// Medication CRUD Modals
window.openEditModal = function(id, name, form, strength, price) {
    document.getElementById('edit-form').action = `/admin/dataset/${id}`;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-form-input').value = form;
    document.getElementById('edit-strength').value = strength;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-modal').classList.remove('hidden');
};
window.closeEditModal = function() { document.getElementById('edit-modal').classList.add('hidden'); };

window.openDeleteModal = function(id, name) {
    document.getElementById('delete-form').action = `/admin/dataset/${id}`;
    document.getElementById('delete-drug-name').textContent = name;
    document.getElementById('delete-modal').classList.remove('hidden');
};
window.closeDeleteModal = function() { document.getElementById('delete-modal').classList.add('hidden'); };

// DPRI CRUD Modals
window.openDpriEditModal = function(id, name, lowest, median, highest, year) {
    document.getElementById('edit-dpri-form').action = `/admin/dataset/dpri/${id}`;
    document.getElementById('edit-dpri-name').value = name;
    document.getElementById('edit-dpri-lowest').value = lowest;
    document.getElementById('edit-dpri-median').value = median;
    document.getElementById('edit-dpri-highest').value = highest;
    document.getElementById('edit-dpri-year').value = year;
    document.getElementById('edit-dpri-modal').classList.remove('hidden');
};
window.closeDpriEditModal = function() { document.getElementById('edit-dpri-modal').classList.add('hidden'); };

window.openDpriDeleteModal = function(id, name) {
    document.getElementById('delete-dpri-form').action = `/admin/dataset/dpri/${id}`;
    document.getElementById('delete-dpri-name').textContent = name;
    document.getElementById('delete-dpri-modal').classList.remove('hidden');
};
window.closeDpriDeleteModal = function() { document.getElementById('delete-dpri-modal').classList.add('hidden'); };