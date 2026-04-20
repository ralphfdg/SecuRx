// resources/js/pharmacist-logs.js

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const dateInput = document.getElementById('dateInput');
    const statusInput = document.getElementById('statusInput');
    const tbody = document.getElementById('logsTableBody');
    
    // Safety check: Only run this script if the table actually exists on the page
    if (!tbody) return;

    const fetchUrl = tbody.getAttribute('data-route');
    let debounceTimer;

    const fetchLogs = () => {
        const params = new URLSearchParams({
            search: searchInput ? searchInput.value : '',
            date: dateInput ? dateInput.value : '',
            status: statusInput ? statusInput.value : ''
        });

        // Set headers to explicitly tell Laravel this is an AJAX request
        fetch(`${fetchUrl}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            tbody.innerHTML = html;
        })
        .catch(error => console.error('Error fetching SecuRx logs:', error));
    };

    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchLogs, 300); 
        });
    }

    if (dateInput) {
        dateInput.addEventListener('change', fetchLogs);
    }

    if (statusInput) {
        statusInput.addEventListener('change', fetchLogs);
    }

    // 4. Intercept Pagination Clicks for seamless AJAX loading
    tbody.addEventListener('click', (e) => {
        // Check if the clicked element is a Laravel pagination link
        const link = e.target.closest('a');
        
        if (link && link.href && link.href.includes('page=')) {
            e.preventDefault(); // Stop the browser from reloading the page
            
            // Fetch the specific page URL that Laravel generated
            fetch(link.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Pagination network error');
                return response.text();
            })
            .then(html => {
                tbody.innerHTML = html; // Inject the new page rows!
            })
            .catch(error => console.error('Error fetching paginated logs:', error));
        }
    });
});