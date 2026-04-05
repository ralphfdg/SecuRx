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
});