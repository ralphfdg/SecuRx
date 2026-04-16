document.addEventListener('DOMContentLoaded', function() {
    // Inject Custom Scrollbar Styles
    const style = document.createElement('style');
    style.textContent = `
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.02); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(28,181,209,0.3); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(28,181,209,0.5); }
    `;
    document.head.append(style);
});

// Attach the function globally so the inline HTML onclick="" attribute can access it
window.loadLivePrescription = function(url) {
    const iframe = document.getElementById('live-rx-frame');
    const placeholder = document.getElementById('live-rx-placeholder');
    
    // Set the URL to load the QR view inside the iframe
    if (iframe) {
        iframe.src = url;
    }
    
    // Hide the placeholder smoothly
    if (placeholder) {
        placeholder.style.opacity = '0';
        setTimeout(() => {
            placeholder.style.display = 'none';
        }, 300);
    }
};