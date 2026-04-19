import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import consultationConsole from './doctor-prescribe.js';
import templateManager from './doctor-templates.js';
import staffManager from './doctor-staff-manager.js';
import patientDirectory from './doctor-directory.js';

// 2. Register the plugin BEFORE starting Alpine
Alpine.plugin(collapse);

// Make the consultation console available globally for the Blade view
window.consultationConsole = consultationConsole;
// Make the template manager available globally for the Blade view
Alpine.data('templateManager', templateManager);
// Make the staff manager available globally for the Blade view
Alpine.data('staffManager', staffManager);
// Make the directory manager available globally for the Blade view
Alpine.data('patientDirectory', patientDirectory);


// 2. Import our Custom Controllers BEFORE Alpine starts
import './pharmacist-scanner';
import './pharmacist-dispense';

// Initialize Alpine
window.Alpine = Alpine;
Alpine.start();

// ==========================================
// SECURX CUSTOM FRONTEND LOGIC
// ==========================================
document.addEventListener('DOMContentLoaded', () => {

    // ------------------------------------------
    // GUEST PORTAL: HARDWARE SCANNER LOGIC
    // ------------------------------------------
    const scannerInput = document.getElementById('scanner-input');
    if (scannerInput) {
        const scannerForm = document.getElementById('scanner-form');
        
        // Keep the input perpetually focused
        document.addEventListener('click', (e) => {
            if (e.target.id !== 'manual-submit' && e.target.id !== 'scanner-input') {
                scannerInput.focus();
            }
        });

        // Handle the routing when the scanner finishes
        scannerForm.addEventListener('submit', (e) => {
            e.preventDefault(); // Stop standard form submission
            
            let scannedData = scannerInput.value.trim();
            
            // Extract the UUID if they scanned the full URL
            if (scannedData.includes('/verify/')) {
                scannedData = scannedData.split('/verify/')[1]; 
            }

            // Redirect them to the Gatekeeper route
            if (scannedData) {
                window.location.href = '/verify/' + scannedData;
            }
        });

        // Listen for the scanner's rapid input
        let typingTimer;
        const doneTypingInterval = 300; // Time in ms to wait after typing stops

        scannerInput.addEventListener('input', () => {
            clearTimeout(typingTimer);
            if (scannerInput.value.length > 10) { 
                typingTimer = setTimeout(() => {
                    // Manually trigger the submit event so our listener above catches it
                    scannerForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                }, doneTypingInterval);
            }
        });
    }

    // ------------------------------------------
    // GUEST PORTAL: PAYLOAD DISPENSE LOGIC
    // ------------------------------------------
    const dispensedToSelect = document.getElementById('dispensed_to');
    if (dispensedToSelect) {
        const manualDiv = document.getElementById('manual_inputs');
        
        dispensedToSelect.addEventListener('change', (e) => {
            if (e.target.value === 'manual') {
                manualDiv.classList.remove('hidden');
                manualDiv.classList.add('grid');
                manualDiv.querySelectorAll('input').forEach(input => input.setAttribute('required', 'true'));
            } else {
                manualDiv.classList.add('hidden');
                manualDiv.classList.remove('grid');
                manualDiv.querySelectorAll('input').forEach(input => input.removeAttribute('required'));
            }
        });
    }


});