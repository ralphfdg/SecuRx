document.addEventListener('alpine:init', () => {
    Alpine.data('scannerController', () => ({
        barcodeBuffer: "",
        lastKeyTime: Date.now(),
        isScanning: false,
        hasData: false,
        manualUuid: "",
        prescriptionId: "",
        date: '',
        patient: {},
        doctor: {},
        prescriptionItems: [],
        durWarnings: [],

        init() {
            document.addEventListener("keydown", this.handleKeystroke.bind(this));
        },

        handleKeystroke(e) {
            if (e.target.tagName === "INPUT") return;
            const currentTime = Date.now();
            if (currentTime - this.lastKeyTime > 50) this.barcodeBuffer = "";
            this.lastKeyTime = currentTime;
            if (e.key.length === 1) this.barcodeBuffer += e.key;
            if (e.key === "Enter" && this.barcodeBuffer.length > 8) {
                e.preventDefault();
                this.processDecryptedUUID(this.barcodeBuffer);
                this.barcodeBuffer = "";
            }
        },

        processDecryptedUUID(uuid) {
            if (!uuid) return;
            this.isScanning = true;
            this.manualUuid = "";

            window.axios.post("/pharmacist/api/scan", { prescription_uuid: uuid })
                .then((response) => {
                    const data = response.data;
                    this.prescriptionId = data.id;
                    this.patient = data.patient;
                    this.doctor = data.doctor;
                    this.date = data.date;
                    this.prescriptionItems = data.items;
                    this.durWarnings = data.dur_warnings;
                    this.hasData = true;
                })
                .catch((err) => alert(err.response?.data?.message || "Invalid Scan."))
                .finally(() => (this.isScanning = false));
        },

        resetScanner() {
            this.hasData = false;
            setTimeout(() => {
                this.prescriptionId = "";
                this.prescriptionItems = [];
                this.durWarnings = [];
            }, 300);
        }
    }));
});