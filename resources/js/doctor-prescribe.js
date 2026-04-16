// We wrap it in an export function so we can register it safely
export default function consultationConsole(config) {
    return {
        activeMic: null,
        showRecordsDrawer: false,
        showTemplatesDrawer: false,
        showDurDrawer: false,
        durAlerts: [],
        isFetchingRecords: false,
        patientId: config.patientId,

        subjective_note: "",
        objective_note: "",
        assessment_note: "",
        plan_note: "",
        showPatientName: false,
        nextAppointment: "",
        generalInstructions: "",

        medications: [],
        newMed: {
            medication_id: 1,
            rxcui: "",
            name: "",
            dose: "",
            dosage_strength: "",
            form: "",
            frequency: "",
            duration: "",
            pharmacist_instructions: "",
            patient_instructions: "",
            sig: "",
            quantity: null,
            est_price: null,
        },
        showGenerateModal: false,
        isGenerating: false,
        isGenerated: false,
        ts: null,
        recognition: null,

        // state variables for the QR and PDF
        generatedPdfUrl: "#",
        prescriptionId: null,
        hasPrescription: false,

        isLoadingRecords: false,
        activePatient: config.patientName || "Unknown Patient",
        patientId: config.patientId,

        // State mapped to your specific HTML design
        recordsData: {
            timeline: [],
        },

        init() {
            // Slight delay to ensure the TomSelect CDN is fully loaded
            setTimeout(() => {
                if (
                    this.$refs.rxnormSearch &&
                    typeof window.TomSelect !== "undefined"
                ) {
                    this.ts = new window.TomSelect(this.$refs.rxnormSearch, {
                        valueField: "id",
                        labelField: "display_name",
                        searchField: ["generic_name", "brand_name"],
                        load: function (query, callback) {
                            if (!query.length) return callback();
                            fetch(
                                `/doctor/api/medications/search?q=${encodeURIComponent(query)}`,
                            )
                                .then((response) => response.json())
                                .then((json) => callback(json))
                                .catch(() => callback());
                        },
                        render: {
                            option: function (item, escape) {
                                // Create the UI elements only if the data exists
                                const doseBadge = item.dosage_strength
                                    ? `<span class="bg-red-100 text-red-700 font-black px-1.5 py-0.5 rounded text-[10px] uppercase ml-2 shadow-sm">${escape(item.dosage_strength)}</span>`
                                    : "";

                                const formText = item.form
                                    ? `<span class="text-xs text-gray-500 ml-1 font-medium">${escape(item.form)}</span>`
                                    : "";

                                const brandText = item.brand_name
                                    ? ` <span class="text-xs text-gray-400 italic ml-1">(${escape(item.brand_name)})</span>`
                                    : "";

                                return `
                                    <div class="flex items-center py-1">
                                    <span class="font-bold text-gray-900">${escape(item.generic_name)}</span>
                                    ${brandText}
                                    ${doseBadge}
                                    ${formText}
                                    </div>
                                    `;
                            },
                            item: function (item, escape) {
                                // This controls how it looks AFTER the doctor clicks it (inside the search box)
                                const doseText = item.dosage_strength
                                    ? ` <span class="text-red-600">[${escape(item.dosage_strength)}]</span>`
                                    : "";
                                return `<div class="font-bold">${escape(item.generic_name)}${doseText}</div>`;
                            },
                        },
                        onChange: (value) => {
                            const selectedItem = this.ts.options[value];
                            if (selectedItem) {
                                this.newMed.medication_id = selectedItem.id;
                                this.newMed.name = selectedItem.generic_name;
                                this.newMed.dosage_strength =
                                    selectedItem.dosage_strength || ""; // Capture 500mg!
                                this.newMed.form = selectedItem.form || ""; // Capture Capsule!

                                this.newMed.rxcui = selectedItem.rxcui;
                                this.newMed.est_price =
                                    selectedItem.median_price || null;
                                this.checkDur(
                                    selectedItem.rxcui,
                                    selectedItem.generic_name,
                                );
                            } else {
                                this.newMed.name = "";
                                this.newMed.rxcui = "";
                                this.newMed.est_price = null;
                            }
                        },
                    });
                }
            }, 100);

            this.$watch("showRecordsDrawer", (value) => {
                if (
                    value &&
                    this.recordsData.timeline.length === 0 &&
                    this.patientId
                ) {
                    this.fetchRecords();
                }
            });

            setTimeout(() => {
                if (this.patientId) {
                    this.checkDur(null, null);
                }
            }, 500);
        },

        patientRecords: [],
        patientProfile: {},
        isFetchingRecords: false,

        // Integrated from Patient Directory
        async fetchRecords() {
            this.isLoadingRecords = true;
            this.isFetchingRecords = true; // Ensure UI loading text shows

            try {
                const response = await fetch(
                    `/doctor/patients/${this.patientId}/records`,
                );
                const data = await response.json();

                // 2. Fix the array mismatch and assign the new profile data
                this.patientRecords = data.timeline || [];
                this.patientProfile = data.profile || {};
            } catch (e) {
                console.error("Clinical Timeline Sync Error:", e);
            } finally {
                this.isLoadingRecords = false;
                this.isFetchingRecords = false;
            }
        },

        async verifyRecord(recordId, recordType) {
            // Human-in-the-Loop: Confirmation gate
            if (
                !confirm(
                    "Officially verify this record for the patient's digital file?",
                )
            )
                return;

            try {
                const response = await fetch(`/doctor/records/verify`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": config.csrfToken,
                    },
                    body: JSON.stringify({ id: recordId, type: recordType }),
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Instantly update UI state for the specific item
                    const record = this.recordsData.timeline.find(
                        (r) => r.id === recordId && r.type === recordType,
                    );
                    if (record) record.is_verified = 1;
                }
            } catch (error) {
                console.error("Verification Error:", error);
                alert("Network error: Could not verify record.");
            }
        },

        async checkDur(rxcui, drugName) {
            if (!this.patientId) return;

            const currentRxcuis = this.medications
                .map((m) => m.rxcui)
                .filter(Boolean);

            try {
                const response = await fetch(`/doctor/api/dur/check`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": config.csrfToken,
                    },
                    body: JSON.stringify({
                        rxcui: rxcui,
                        patient_id: this.patientId,
                        drug_name: drugName,
                        current_rxcuis: currentRxcuis,
                    }),
                });

                const data = await response.json();

                // NEW: Print the backend's internal logs to your browser console
                //if (data.debug) {
                //   console.group("--- Backend DUR Debug Logs ---");
                //   data.debug.forEach((log) => console.log(log));
                //   console.groupEnd();
                //}

                this.durAlerts = data.alerts || [];

                // ONLY open the drawer if a NEW interaction/allergy was explicitly matched
                if (data.trigger_drawer) {
                    console.log("Critical Alert found! Opening drawer.");
                    this.showDurDrawer = true;
                }
            } catch (e) {
                console.error("DUR Fetch Error:", e);
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

                const SpeechRecognition =
                    window.SpeechRecognition || window.webkitSpeechRecognition;
                if (!SpeechRecognition) {
                    alert(
                        "Speech recognition is not supported in this browser.",
                    );
                    this.activeMic = null;
                    return;
                }

                this.recognition = new SpeechRecognition();
                this.recognition.continuous = true;
                this.recognition.interimResults = true;

                this.recognition.onresult = (event) => {
                    let finalTranscript = "";
                    for (
                        let i = event.resultIndex;
                        i < event.results.length;
                        ++i
                    ) {
                        if (event.results[i].isFinal) {
                            finalTranscript +=
                                event.results[i][0].transcript + " ";
                        }
                    }
                    if (finalTranscript) {
                        this[`${section}_note`] = (
                            this[`${section}_note`] +
                            " " +
                            finalTranscript
                        ).trim();
                    }
                };

                this.recognition.onerror = (event) => {
                    console.error("Speech recognition error", event.error);
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
                    medication_id: 1,
                    rxcui: "",
                    name: "",
                    dose: "",
                    dosage_strength: "",
                    form: "",
                    frequency: "",
                    duration: "",
                    pharmacist_instructions: "",
                    patient_instructions: "",
                    sig: "",
                    quantity: null,
                    est_price: null,
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
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": config.csrfToken,
                    },
                    body: JSON.stringify({
                        subjective_note: this.subjective_note,
                        objective_note: this.objective_note,
                        assessment_note: this.assessment_note,
                        plan_note: this.plan_note,
                        next_appointment_date: this.nextAppointment,
                        print_patient_name: this.showPatientName,
                        general_instructions: this.generalInstructions,
                        medications: this.medications,
                    }),
                });
                const data = await response.json();

                if (response.ok && data.success) {
                    // Capture the new backend variables!
                    this.hasPrescription = data.has_prescription || false;
                    this.prescriptionId = data.prescription_id || null;
                    this.generatedPdfUrl = data.pdf_url || "#";

                    setTimeout(() => {
                        this.isGenerating = false;
                        this.isGenerated = true;
                    }, 1000);
                } else {
                    alert(
                        "Failed to generate prescription: " +
                            (data.message || "Unknown error"),
                    );
                    this.isGenerating = false;
                    this.showGenerateModal = false;
                }
            } catch (error) {
                console.error("Error:", error);
                alert("An error occurred while saving the consultation.");
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
            el.style.height = "auto";
            el.style.height = el.scrollHeight + "px";
        },

        calculateSigAndQty() {
            let fMultiplier = 0;
            let freq = (this.newMed.frequency || "").toUpperCase();

            // Fuzzy matching for typed text
            if (freq.includes("OD") || freq.includes("ONCE")) fMultiplier = 1;
            else if (freq.includes("BID") || freq.includes("TWICE"))
                fMultiplier = 2;
            else if (freq.includes("TID") || freq.includes("THRICE"))
                fMultiplier = 3;
            else if (freq.includes("QID") || freq.includes("FOUR TIMES"))
                fMultiplier = 4;
            else if (freq.includes("Q4H")) fMultiplier = 6;
            else if (freq.includes("Q6H")) fMultiplier = 4;

            // Extract the text and the number
            let doseString = (this.newMed.dose || "").toLowerCase();
            let doseMatch = doseString.match(/[\d\.]+/);
            let doseVal = doseMatch ? parseFloat(doseMatch[0]) : 0;
            let durationVal = parseInt(this.newMed.duration) || 0;

            // NEW: Check if the doctor is typing a liquid or bottle-based measurement
            let isLiquid =
                doseString.includes("ml") ||
                doseString.includes("cc") ||
                doseString.includes("drop") ||
                doseString.includes("tsp") ||
                doseString.includes("tbsp") ||
                doseString.includes("bottle");

            // Auto calculate if all vars are found
            if (doseVal > 0 && fMultiplier > 0 && durationVal > 0) {
                if (isLiquid) {
                    // If it's a liquid, QTY usually means "Bottles". Default to 1.
                    this.newMed.quantity = 1;
                } else {
                    // If it's tabs, caps, or sachets, calculate the exact total count
                    this.newMed.quantity = Math.ceil(
                        doseVal * fMultiplier * durationVal,
                    );
                }
            }

            // Always attempt to build the Sig
            if (this.newMed.dose && this.newMed.frequency) {
                this.newMed.sig = `Take ${this.newMed.dose} ${this.newMed.frequency} for ${this.newMed.duration || "[X]"} Days`;
            }
        },
    };
}
