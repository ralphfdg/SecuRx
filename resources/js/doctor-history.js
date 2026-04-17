document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    if (!filterForm) return;

    const searchInput = document.getElementById('search-input');
    const clearSearchBtn = document.getElementById('clear-search-btn');
    const statusSelect = document.getElementById('status-select');
    const dateInput = document.getElementById('date-input');
    const tableBody = document.getElementById('table-body');
    const loadingOverlay = document.getElementById('loading-overlay');
    const exportBtn = document.getElementById('export-btn');

    const fetchUrl = filterForm.getAttribute('data-fetch-url');
    const exportBaseUrl = exportBtn.getAttribute('data-base-url');

    let debounceTimer;

    function toggleClearButton() {
        if (searchInput.value.length > 0) {
            clearSearchBtn.classList.remove('hidden');
        } else {
            clearSearchBtn.classList.add('hidden');
        }
    }

    function updateTable() {
        loadingOverlay.classList.remove('hidden');

        const params = new URLSearchParams({
            search: searchInput.value,
            status: statusSelect.value,
            date: dateInput.value
        });

        // Update Export Link
        exportBtn.href = `${exportBaseUrl}?${params.toString()}`;

        // Fetch Data
        fetch(`${fetchUrl}?${params.toString()}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            tableBody.innerHTML = html;
        })
        .finally(() => {
            loadingOverlay.classList.add('hidden');
        });
    }

    // Initialize button state
    toggleClearButton();

    // Search Input Logic
    searchInput.addEventListener('input', () => {
        toggleClearButton();
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(updateTable, 350);
    });

    // Clear Button Logic
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        toggleClearButton();
        updateTable(); // Fetch immediately on clear
        searchInput.focus();
    });

    // Filter Listeners
    statusSelect.addEventListener('change', updateTable);
    dateInput.addEventListener('change', updateTable);
});