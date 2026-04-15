export default function patientDirectory() {
    return {
        showEditDrawer: false,
        showRegisterDrawer: false,
        showRecordsDrawer: false,
        activePatient: '',
        isLoadingRecords: false,

        // State for the Create Form (Required for Credential Gen)
        regForm: {
            first_name: '',
            last_name: '',
            username: '',
            password: ''
        },

        // Extended State for the Edit Form
        editForm: {
            id: '',
            first_name: '',
            middle_name: '',
            last_name: '',
            qualifier: '',
            dob: '',
            gender: '',
            email: '',
            mobile_num: '',
            height: '',
            weight: '',
            address: '',
            school_work: '',
            mother_name: '',
            mother_contact: '',
            father_name: '',
            father_contact: ''
        },

        recordsData: {
            timeline: []
        },

        generateCredentials() {
            // Ensure names are provided before generating
            if (!this.regForm.first_name || !this.regForm.last_name) {
                alert("Please enter the First Name and Last Name first.");
                return;
            }

            // Clean inputs: lowercased, remove spaces, keep alphanumeric
            const fName = this.regForm.first_name.toLowerCase().replace(/[^a-z0-9]/g, '');
            const lName = this.regForm.last_name.toLowerCase().replace(/[^a-z0-9]/g, '');
            const randomDigits = Math.floor(100 + Math.random() * 900); // 3 random digits

            // Populate Username: e.g., jdelacruz452
            this.regForm.username = `${fName.charAt(0)}${lName}${randomDigits}`;

            // Populate Password: e.g., SecuRx-8H7pZ
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
            let randomStr = '';
            for (let i = 0; i < 5; i++) {
                randomStr += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            this.regForm.password = `SecuRx-${randomStr}`;
        },

        openEditDrawer(patient, patientProfile) {
            this.editForm = {
                id: patient.id,
                first_name: patient.first_name || '',
                middle_name: patient.middle_name || '',
                last_name: patient.last_name || '',
                qualifier: patient.qualifier || '',
                dob: patient.dob ? patient.dob.split('T')[0] : '',
                gender: patient.gender || '',
                email: patient.email || '',
                mobile_num: patient.mobile_num || '',
                
                // Safely map profile data if it exists
                height: patientProfile ? patientProfile.height : '',
                weight: patientProfile ? patientProfile.weight : '',
                address: patientProfile ? patientProfile.address : '',
                school_work: patientProfile ? patientProfile.school_work : '',
                mother_name: patientProfile ? patientProfile.mother_name : '',
                mother_contact: patientProfile ? patientProfile.mother_contact : '',
                father_name: patientProfile ? patientProfile.father_name : '',
                father_contact: patientProfile ? patientProfile.father_contact : ''
            };
            this.showEditDrawer = true;
        },

        async openRecords(patientId, patientName) {
            this.activePatient = patientName;
            this.showRecordsDrawer = true;
            this.isLoadingRecords = true;

            try {
                const response = await fetch(`/doctor/patients/${patientId}/records`);
                if (response.ok) {
                    this.recordsData = await response.json();
                }
            } catch (error) {
                console.error("Error fetching records", error);
            } finally {
                this.isLoadingRecords = false;
            }
        },

        async verifyRecord(recordId, recordType) {
            // Confirm with the doctor first for safety
            if (!confirm("Are you sure you want to officially verify this clinical record?")) {
                return;
            }

            try {
                // Assuming you placed the route in web.php, we need the CSRF token.
                // If this is strictly an API route without CSRF, you can remove the X-CSRF-TOKEN header.
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const response = await fetch(`/doctor/patients/records/verify`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken 
                    },
                    body: JSON.stringify({
                        id: recordId,
                        type: recordType
                    })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Instantly update the UI without reloading the database
                    const recordIndex = this.recordsData.timeline.findIndex(r => r.id === recordId && r.type === recordType);
                    if (recordIndex !== -1) {
                        this.recordsData.timeline[recordIndex].is_verified = 1;
                    }
                    
                    // Optional: Use your Toastify or alert here
                    alert("Record officially verified.");
                } else {
                    alert("Failed to verify record. Please try again.");
                }
            } catch (error) {
                console.error("Error verifying record:", error);
                alert("A network error occurred.");
            }
        }
    };
}