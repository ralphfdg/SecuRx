// resources/js/medical-profile.js

document.addEventListener('DOMContentLoaded', function() {
    
    // Attach the switchTab function globally so inline onClick events can access it
    window.switchTab = function(tabId) {
        
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.remove('block');
            el.classList.add('hidden');
        });

        // Show selected content
        const selectedContent = document.getElementById('content-' + tabId);
        if (selectedContent) {
            selectedContent.classList.remove('hidden');
            selectedContent.classList.add('block');
        }

        // Reset all buttons to default inactive state
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-securx-cyan', 'text-securx-cyan');
            btn.classList.add('border-transparent', 'text-slate-500');
        });

        // Highlight active button
        const activeBtn = document.getElementById('tab-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-slate-500');
            activeBtn.classList.add('border-securx-cyan', 'text-securx-cyan');
        }
    };
});