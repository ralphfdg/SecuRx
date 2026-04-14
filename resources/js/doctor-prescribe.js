// We wrap it in an export function so we can register it safely
export default function consultationConsole(config) {
    return {
        activeMic: null,
        showRecordsDrawer: false,
        showTemplatesDrawer: false,
        showDurDrawer: false,
        durAlerts: [],
        patientRecords: [],
        isFetchingRecords: false,
        patientId: config.patientId, 

        subjective_note: '',
        objective_note: '',
        assessment_note: '',
        plan_note: '',
        showPatientName: false,
        nextAppointment: '',
        generalInstructions: '',

        medications: [],
        newMed: {
            medication_id: 1,
            rxcui: '',
            name: '',
            dose: '',
            frequency: '',
            duration: '',
            pharmacist_instructions: '',
            patient_instructions: '',
            sig: '',
            quantity: null,
            est_price: null
        },
        showGenerateModal: false,
        isGenerating: false,
        isGenerated: false,
        ts: null,
        recognition: null,

        init() {
            // Slight delay to ensure the TomSelect CDN is fully loaded
            setTimeout(() => {
                if (this.$refs.rxnormSearch && typeof window.TomSelect !== 'undefined') {
                    this.ts = new window.TomSelect(this.$refs.rxnormSearch, {
                        valueField: 'id',
                        labelField: 'display_name',
                        searchField: ['generic_name', 'brand_name'],
                        load: function(query, callback) {
                            if (!query.length) return callback();
                            fetch(`/doctor/api/medications/search?q=${encodeURIComponent(query)}`)
                                .then(response => response.json())
                                .then(json => callback(json))
                                .catch(() => callback());
                        },
                        render: {
                            option: function(item, escape) {
                                return `<div><span class="font-bold">${escape(item.generic_name)}</span>` +
                                    (item.brand_name ? ` <span class="text-xs text-gray-500">(${escape(item.brand_name)})</span>` : '') +
                                    `</div>`;
                            },
                            item: function(item, escape) {
                                return `<div>${escape(item.generic_name)}</div>`;
                            }
                        },
                        onChange: (value) => {
                            const selectedItem = this.ts.options[value];
                            if (selectedItem) {
                                this.newMed.medication_id = selectedItem.id;
                                this.newMed.name = selectedItem.generic_name;
                                this.newMed.rxcui = selectedItem.rxcui;
                                this.newMed.est_price = selectedItem.median_price || null;
                                this.checkDur(selectedItem.rxcui, selectedItem.generic_name);
                            } else {
                                this.newMed.name = '';
                                this.newMed.rxcui = '';
                                this.newMed.est_price = null;
                            }
                        }
                    });
                }
            }, 100);

            this.$watch('showRecordsDrawer', value => {
                if (value && this.patientRecords.length === 0 && this.patientId) {
                    this.fetchRecords();
                }
            });
        },

        async fetchRecords() {
            this.isFetchingRecords = true;
            try {
                const response = await fetch(`/doctor/api/patients/${this.patientId}/records`);
                const data = await response.json();
                this.patientRecords = data.timeline || [];
            } catch (e) {
                console.error(e);
            } finally {
                this.isFetchingRecords = false;
            }
        },

        async checkDur(rxcui, drugName) {
            if (!rxcui || !this.patientId) return;
            try {
                const response = await fetch(`/doctor/api/dur/check`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrfToken
                    },
                    body: JSON.stringify({
                        rxcui: rxcui,
                        patient_id: this.patientId,
                        drug_name: drugName
                    })
                });
                const data = await response.json();
                if (data.has_alerts) {
                    this.durAlerts = data.alerts;
                    this.showDurDrawer = true;
                }
            } catch (e) {
                console.error(e);
            }
        },

        toggleMic(section) {
            if (this.activeMic === section) {
                if (this.recognition) {
                    this.recognition.stop();
                }
                this.activeMic = null;
            } else {
                if (this.recognition) {
                    this.recognition.stop();
                }
                this.activeMic = section;

                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                if (!SpeechRecognition) {
                    alert('Speech recognition is not supported in this browser.');
                    this.activeMic = null;
                    return;
                }

                this.recognition = new SpeechRecognition();
                this.recognition.continuous = true;
                this.recognition.interimResults = true;

                this.recognition.onresult = (event) => {
                    let finalTranscript = '';
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            finalTranscript += event.results[i][0].transcript + ' ';
                        }
                    }
                    if (finalTranscript) {
                        this[`${section}_note`] = (this[`${section}_note`] + ' ' + finalTranscript).trim();
                    }
                };

                this.recognition.onerror = (event) => {
                    console.error('Speech recognition error', event.error);
                    this.activeMic = null;
                };

                this.recognition.onend = () => {
                    if (this.activeMic === section) {
                        this.activeMic = null;
                    }
                };

                this.recognition.start();
            }
        },

        addMedication() {
            if (this.newMed.name) {
                this.medications.push({ ...this.newMed });
                this.newMed = {
                    medication_id: 1, rxcui: '', name: '', dose: '', frequency: '',
                    duration: '', pharmacist_instructions: '', patient_instructions: '',
                    sig: '', quantity: null, est_price: null
                };
                if (this.ts) {
                    this.ts.clear();
                }
            }
        },
        
        removeMedication(index) {
            this.medications.splice(index, 1);
        },

        async confirmGeneration() {
            this.isGenerating = true;
            try {
                const response = await fetch(config.storeRoute, { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrfToken 
                    },
                    body: JSON.stringify({
                        subjective_note: this.subjective_note,
                        objective_note: this.objective_note,
                        assessment_note: this.assessment_note,
                        plan_note: this.plan_note,
                        next_appointment_date: this.nextAppointment,
                        print_patient_name: this.showPatientName,
                        general_instructions: this.generalInstructions,
                        medications: this.medications
                    })
                });
                const data = await response.json();
                if (response.ok && data.success) {
                    setTimeout(() => {
                        this.isGenerating = false;
                        this.isGenerated = true;
                    }, 1000);
                } else {
                    alert('Failed to generate prescription: ' + (data.message || 'Unknown error'));
                    this.isGenerating = false;
                    this.showGenerateModal = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while saving the consultation.');
                this.isGenerating = false;
                this.showGenerateModal = false;
            }
        },

        closeAllDrawers() {
            this.showRecordsDrawer = false;
            this.showTemplatesDrawer = false;
            this.showDurDrawer = false;
            this.showGenerateModal = false;
        },
        
        resizeTextarea(e) {
            let el = e.target;
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        }
    };
}