document.addEventListener('DOMContentLoaded', function() {
    
    window.selectPatient = function(id, name, time, provider) {
        // 1. Update the display text in the header
        document.getElementById('display_name').innerText = name;
        document.getElementById('display_time').innerText = time;
        document.getElementById('display_provider').innerText = provider;
        
        // 2. Inject the UUID into both the Triage form AND the No-Show form
        document.getElementById('form_appointment_id').value = id;
        document.getElementById('no_show_appointment_id').value = id;
        
        // 3. Swap the views
        document.getElementById('empty_state').classList.add('hidden');
        document.getElementById('triage_form_container').classList.remove('hidden');
        document.getElementById('triage_form_container').classList.add('flex');
    };

    window.closeTriage = function() {
        document.getElementById('triage_form_container').classList.add('hidden');
        document.getElementById('triage_form_container').classList.remove('flex');
        document.getElementById('empty_state').classList.remove('hidden');
        
        // Reset the form so previous patient data isn't accidentally submitted
        document.getElementById('triage_form').reset();
    };

});