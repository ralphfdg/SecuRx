const initDispense = () => {
    window.Alpine.data('dispenseController', (prescriptionId, availableItems, submitUrl, requiresOverride) => ({
        isSubmitting: false, 
        isSuccess: false, 
        errorMessage: '',
        global_override_reason: '',
        
        receiver_id_presented: '',
        pickup_type: 'patient', 
        representative_name: '',
        isDrawerOpen: false,
        
        itemsForm: availableItems.map(item => ({
            selected: true,
            item_id: item.id,
            name: item.medication.brand_name,
            max_qty: item.quantity_remaining !== null ? item.quantity_remaining : item.quantity,
            actual_drug_dispensed: '',
            quantity_dispensed: item.quantity_remaining !== null ? item.quantity_remaining : item.quantity,
            lot_number: '', 
            expiry_date: ''
        })),

        get is_proxy() {
            return this.pickup_type === 'proxy';
        },

        get selectedItems() {
            return this.itemsForm.filter(i => i.selected);
        },

        // Strict Button Validation Engine
        get isFormValid() {
            if (!this.receiver_id_presented) return false;
            if (this.is_proxy && !this.representative_name) return false;
            if (this.selectedItems.length === 0) return false;

            const hasEmptyFields = this.selectedItems.some(item => 
                !item.actual_drug_dispensed || !item.quantity_dispensed || !item.lot_number || !item.expiry_date
            );
            if (hasEmptyFields) return false;

            // If there is a Red or Yellow alert, the pharmacist MUST type a reason to unlock the button.
            if (requiresOverride && !this.global_override_reason.trim()) return false;

            return true;
        },

        submitDispense() {
            if (!this.isFormValid) return;

            this.isSubmitting = true; 
            this.errorMessage = '';
            
            window.axios.post(submitUrl, { 
                receiver_id_presented: this.receiver_id_presented,
                is_proxy: this.is_proxy,
                representative_name: this.representative_name,
                items: this.selectedItems,
                global_override_reason: this.global_override_reason
            })
            .then(() => {
                this.isSuccess = true;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            })
            .catch(err => {
                this.errorMessage = err.response?.data?.message || 'Error saving to ledger.';
            })
            .finally(() => {
                this.isSubmitting = false;
            });
        }
    }));
};

if (window.Alpine) {
    initDispense();
} else {
    document.addEventListener("alpine:init", initDispense);
}