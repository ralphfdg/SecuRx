document.addEventListener('DOMContentLoaded', function() {

    window.openPatientModal = function(mode, patientData = null) {
        const modal = document.getElementById('patient_modal');
        const form = document.getElementById('patient_form');
        const methodInput = document.getElementById('form_method');
        const title = document.getElementById('modal_title');
        const btnSubmit = document.getElementById('btn_submit');

        // Reset form to clear previous data
        form.reset();

        if (mode === 'create') {
            title.innerText = 'Patient Registration';
            btnSubmit.innerText = 'Submit Registration';
            
            // Grab the secure POST route from the data attribute
            form.action = form.dataset.storeUrl; 
            methodInput.value = "POST";

            // Show Security Section & Require Fields
            document.getElementById('account_security_section').classList.remove('hidden');
            document.getElementById('inp_username').setAttribute('required', 'required');
            document.getElementById('inp_password').setAttribute('required', 'required');
            document.getElementById('inp_password_confirmation').setAttribute('required', 'required');

        } else if (mode === 'edit' && patientData) {
            title.innerText = 'Edit Patient Profile';
            btnSubmit.innerText = 'Update Profile';
            
            // Dynamically set the PUT route
            form.action = `/secretary/patients/${patientData.id}`;
            methodInput.value = "PUT";

            // Hide Security Section & Remove Required Flags
            document.getElementById('account_security_section').classList.add('hidden');
            document.getElementById('inp_username').removeAttribute('required');
            document.getElementById('inp_password').removeAttribute('required');
            document.getElementById('inp_password_confirmation').removeAttribute('required');

            // Populate core user fields safely
            document.getElementById('inp_first_name').value = patientData.first_name || '';
            document.getElementById('inp_last_name').value = patientData.last_name || '';
            document.getElementById('inp_email').value = patientData.email || '';
            document.getElementById('inp_mobile_num').value = patientData.mobile_num || '';
            document.getElementById('inp_dob').value = patientData.dob || '';
            document.getElementById('inp_gender').value = patientData.gender || '';

            // Populate nested patient_profile fields safely
            if(patientData.patient_profile) {
                document.getElementById('inp_middle_name').value = patientData.patient_profile.middle_name || '';
                document.getElementById('inp_qualifier').value = patientData.patient_profile.qualifier || '';
                document.getElementById('inp_height').value = patientData.patient_profile.height || '';
                document.getElementById('inp_weight').value = patientData.patient_profile.weight || '';
                document.getElementById('inp_address').value = patientData.patient_profile.address || '';
                document.getElementById('inp_school_work').value = patientData.patient_profile.school_work || '';
                document.getElementById('inp_mother_name').value = patientData.patient_profile.mother_name || '';
                document.getElementById('inp_mother_contact').value = patientData.patient_profile.mother_contact || '';
                document.getElementById('inp_father_name').value = patientData.patient_profile.father_name || '';
                document.getElementById('inp_father_contact').value = patientData.patient_profile.father_contact || '';
            }
        }

        // Display Modal
        modal.classList.remove('hidden');
        modal.classList.add('block');
    };

    window.closePatientModal = function() {
        const modal = document.getElementById('patient_modal');
        modal.classList.add('hidden');
        modal.classList.remove('block');
    };

});