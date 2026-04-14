export default function staffManager(config) {
    return {
        showDrawer: false,
        showRevokeModal: false,
        isEditing: false,
        
        // Modal state data
        staffToRevokeName: '',
        staffActionId: null,
        
        // Form controls
        formAction: config.storeRoute,
        formMethod: 'POST',
        
        formData: {
            first_name: '',
            last_name: '',
            email: '',
            mobile_num: '' // Updated to match DB
        },
        
        openDrawer(mode, staff = null) {
            this.isEditing = mode === 'edit';
            
            if (this.isEditing && staff) {
                this.formData.first_name = staff.first_name;
                this.formData.last_name = staff.last_name;
                this.formData.email = staff.email;
                this.formData.mobile_num = staff.mobile_num;
                
                this.formAction = `/doctor/staff/${staff.id}`;
                this.formMethod = 'PATCH';
            } else {
                this.formData.first_name = '';
                this.formData.last_name = '';
                this.formData.email = '';
                this.formData.mobile_num = '';
                
                this.formAction = config.storeRoute;
                this.formMethod = 'POST';
            }
            
            this.showDrawer = true;
        },

        confirmRevoke(id, name) {
            this.staffActionId = id;
            this.staffToRevokeName = name;
            this.showRevokeModal = true;
        }
    }
}