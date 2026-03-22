@extends('layouts.doctor')

@section('page_title', 'Issue Secure Prescription')

@section('content')
    <div class="max-w-7xl mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-5 flex flex-col h-full">
                <h3 class="text-sm font-bold text-securx-navy uppercase tracking-wider mb-3 px-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Clinical Intelligence
                </h3>

                <div id="intel-empty"
                    class="flex-1 bg-slate-800 border border-slate-700 rounded-2xl p-8 shadow-lg flex flex-col items-center justify-center text-center transition-all duration-300">
                    <div
                        class="w-16 h-16 bg-slate-700/50 rounded-full flex items-center justify-center text-slate-500 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-slate-400 font-medium">Select a patient from the directory to securely load their medical
                        profile and DUR data.</p>
                </div>

                <div id="intel-populated"
                    class="hidden flex-1 bg-slate-800 border border-slate-700 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 flex flex-col">
                    <div class="p-6 border-b border-slate-700 bg-slate-900/30">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-securx-cyan/20 text-securx-cyan flex items-center justify-center font-bold text-lg border border-securx-cyan/30"
                                id="intel-initials"></div>
                            <div>
                                <h2 class="text-xl font-extrabold text-white leading-tight" id="intel-name">Patient Name
                                </h2>
                                <p class="text-xs text-slate-400 font-mono mt-0.5" id="intel-uuid">UUID: -----</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6 flex-1 overflow-y-auto">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-900/50 p-3 rounded-lg border border-slate-700/50">
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Date of Birth</p>
                                <p class="text-sm text-slate-200 font-bold" id="intel-dob">--</p>
                            </div>
                            <div class="bg-slate-900/50 p-3 rounded-lg border border-slate-700/50">
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Blood Type</p>
                                <p class="text-sm text-red-400 font-bold" id="intel-blood">--</p>
                            </div>
                        </div>

                        <div>
                            <h4
                                class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span> Known Allergies
                            </h4>
                            <div id="intel-allergies-container">
                            </div>
                        </div>

                        <div>
                            <h4
                                class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-securx-gold"></span> Chronic Conditions
                            </h4>
                            <p class="text-sm text-slate-300 bg-slate-900/50 p-3 rounded-lg border border-slate-700/50"
                                id="intel-conditions">--</p>
                        </div>

                        <div>
                            <h4
                                class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-securx-cyan"></span> Active Prescriptions
                            </h4>
                            <div id="intel-active-rx" class="space-y-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">

                <div id="prescription-form-container"
                    class="glass-panel p-8 bg-white/90 transition-all duration-500 h-full">

                    <div class="mb-8 border-b border-gray-200 pb-6">
                        <h2 class="text-2xl font-extrabold text-securx-navy">Generate e-Prescription</h2>
                        <p class="text-sm text-gray-500 mt-1">Cryptographic key will be locked to the selected patient's
                            profile.</p>
                    </div>

                    <form id="mock-prescription-form" class="space-y-6" onsubmit="generatePresentationQR(event)">

                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Select Patient Directory
                                *</label>
                            <select id="patient_select" class="glass-input w-full py-3 px-4 text-base font-medium" required
                                onchange="loadPatientData(this.value)">
                                <option value="" disabled selected>Search by name or ID...</option>
                                <option value="ralph">Ralph De Guzman (DOB: Jan 15, 2005)</option>
                                <option value="maria">Maria Clara (DOB: Oct 02, 1990)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Medication Name & Strength
                                    *</label>
                                <input type="text" id="medication" placeholder="e.g. Amoxicillin 500mg"
                                    class="glass-input w-full py-2.5 px-4" required onkeyup="checkDURWarning()">
                                <p id="dur-warning-text"
                                    class="text-xs font-bold text-red-600 mt-1 hidden flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    DUR ALERT: Patient has a documented allergy to this medication class.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Dosage / Sig *</label>
                                <input type="text" placeholder="e.g. 1 cap 3x a day"
                                    class="glass-input w-full py-2.5 px-4" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Duration *</label>
                                <input type="text" placeholder="e.g. 7 days" class="glass-input w-full py-2.5 px-4"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Quantity to Dispense
                                    *</label>
                                <input type="number" placeholder="e.g. 21" class="glass-input w-full py-2.5 px-4" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Refills Allowed</label>
                                <input type="number" value="0" class="glass-input w-full py-2.5 px-4" required>
                            </div>
                        </div>

                        <div class="p-5 bg-securx-navy/5 border border-securx-navy/10 rounded-xl mt-6">
                            <label class="block text-sm font-bold text-securx-navy mb-2">Digital Signature PIN *</label>
                            <div class="flex flex-col sm:flex-row gap-4 items-center">
                                <input type="password" placeholder="••••"
                                    class="glass-input w-full sm:w-32 py-2.5 px-4 text-center tracking-widest font-bold text-lg"
                                    maxlength="4" required>
                                <span class="text-xs text-gray-500 font-medium">Verify your identity to cryptographically
                                    sign and lock this record into the SecuRx network.</span>
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" id="submit-btn"
                                class="glass-btn-primary py-3.5 px-8 text-base flex items-center gap-2 w-full sm:w-auto justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Sign & Generate Key
                            </button>
                        </div>
                    </form>
                </div>

                <div id="qr-success-container"
                    class="hidden glass-panel p-10 bg-white/95 text-center transition-all duration-500 border-t-4 border-t-green-500 h-full flex flex-col justify-center">
                    <div
                        class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-500 mx-auto mb-6 border-4 border-white shadow-md">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-extrabold text-securx-navy mb-2">Prescription Issued Successfully</h2>
                    <p class="text-sm text-gray-500 mb-8">This payload has been encrypted and securely transmitted to the
                        patient's mobile portal.</p>

                    <div
                        class="bg-white p-4 inline-block mx-auto rounded-2xl border border-gray-200 shadow-xl mb-8 relative hover:scale-105 transition-transform duration-300">
                        <img id="generated-qr-image" src="" alt="Secure UUID QR Code" class="w-56 h-56">
                        <div
                            class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-securx-navy text-white text-[11px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest whitespace-nowrap shadow-md">
                            UUID: <span id="display-uuid"></span>
                        </div>
                    </div>

                    <div class="flex justify-center gap-4 mt-auto">
                        <button onclick="resetForm()" class="glass-btn-secondary py-3 px-8 text-sm">Issue Another</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Mock Database for the Presentation
        const patientData = {
            'ralph': {
                name: 'Ralph De Guzman',
                initials: 'RD',
                uuid: '8F92A-4B7C1',
                dob: 'Jan 15, 2005 (21)',
                blood: 'O+',
                allergies: ['Penicillin', 'Latex'],
                conditions: 'None reported',
                activeRx: [{
                    name: 'Cetirizine 10mg',
                    sig: '1 tab daily'
                }]
            },
            'maria': {
                name: 'Maria Clara',
                initials: 'MC',
                uuid: '2C44F-9A1B2',
                dob: 'Oct 02, 1990 (35)',
                blood: 'A-',
                allergies: ['None known'],
                conditions: 'Hypertension',
                activeRx: [{
                        name: 'Lisinopril 10mg',
                        sig: '1 tab daily'
                    },
                    {
                        name: 'Amlodipine 5mg',
                        sig: '1 tab at bedtime'
                    }
                ]
            }
        };

        function loadPatientData(patientKey) {
            if (!patientKey) return;

            // Hide empty state, show populated state
            document.getElementById('intel-empty').classList.add('hidden');
            document.getElementById('intel-populated').classList.remove('hidden');

            const data = patientData[patientKey];

            // Populate basic text
            document.getElementById('intel-name').innerText = data.name;
            document.getElementById('intel-initials').innerText = data.initials;
            document.getElementById('intel-uuid').innerText = `UUID: ${data.uuid}`;
            document.getElementById('intel-dob').innerText = data.dob;
            document.getElementById('intel-blood').innerText = data.blood;
            document.getElementById('intel-conditions').innerText = data.conditions;

            // Render Allergies
            const allergyContainer = document.getElementById('intel-allergies-container');
            allergyContainer.innerHTML = ''; // clear previous
            if (data.allergies[0] === 'None known') {
                allergyContainer.innerHTML =
                    `<p class="text-sm text-slate-300 bg-slate-900/50 p-3 rounded-lg border border-slate-700/50">No known allergies</p>`;
            } else {
                data.allergies.forEach(allergy => {
                    allergyContainer.innerHTML += `<div class="p-3 bg-red-900/20 border border-red-500/30 rounded-lg flex justify-between items-center mb-2">
                    <span class="font-bold text-red-400 text-sm">${allergy}</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-red-500 bg-red-500/10 px-2 py-0.5 rounded">Severe</span>
                </div>`;
                });
            }

            // Render Active Rx
            const rxContainer = document.getElementById('intel-active-rx');
            rxContainer.innerHTML = '';
            data.activeRx.forEach(rx => {
                rxContainer.innerHTML += `<div class="p-3 bg-slate-900/50 border border-slate-700/50 rounded-lg">
                <p class="font-bold text-securx-cyan text-sm">${rx.name}</p>
                <p class="text-xs text-slate-400 mt-0.5">${rx.sig}</p>
            </div>`;
            });

            // Trigger a check in case they typed the drug before selecting the patient
            checkDURWarning();
        }

        // Real-time DUR Simulator
        function checkDURWarning() {
            const patientKey = document.getElementById('patient_select').value;
            const medicationInput = document.getElementById('medication').value.toLowerCase();
            const warningText = document.getElementById('dur-warning-text');
            const inputField = document.getElementById('medication');
            const submitBtn = document.getElementById('submit-btn');

            if (patientKey === 'ralph' && medicationInput.includes('penicillin')) {
                // Trigger Visual Warning
                warningText.classList.remove('hidden');
                inputField.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                submitBtn.classList.replace('glass-btn-primary', 'bg-gray-400');
                submitBtn.classList.add('cursor-not-allowed');
                submitBtn.disabled = true;
                submitBtn.innerHTML = "Prescription Blocked by DUR";
            } else {
                // Remove Warning
                warningText.classList.add('hidden');
                inputField.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                submitBtn.classList.replace('bg-gray-400', 'glass-btn-primary');
                submitBtn.classList.remove('cursor-not-allowed');
                submitBtn.disabled = false;
                submitBtn.innerHTML =
                    `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> Sign & Generate Key`;
            }
        }

        function generatePresentationQR(event) {
            event.preventDefault();

            // Generate a fake UUID
            const mockUUID = Math.random().toString(36).substring(2, 7).toUpperCase() + '-' + Math.random().toString(36)
                .substring(2, 7).toUpperCase();
            document.getElementById('display-uuid').innerText = mockUUID;

            // Generate QR Code via API
            document.getElementById('generated-qr-image').src =
                `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=SecuRx:${mockUUID}&color=0F172A`;

            // Hide Form, Show Success
            document.getElementById('prescription-form-container').classList.add('hidden');
            document.getElementById('qr-success-container').classList.remove('hidden');
        }

        function resetForm() {
            document.getElementById('mock-prescription-form').reset();
            document.getElementById('qr-success-container').classList.add('hidden');
            document.getElementById('prescription-form-container').classList.remove('hidden');

            // Reset the Intel panel back to empty state
            document.getElementById('patient_select').value = "";
            document.getElementById('intel-populated').classList.add('hidden');
            document.getElementById('intel-empty').classList.remove('hidden');

            checkDURWarning(); // Reset any warnings
        }
    </script>
@endsection
