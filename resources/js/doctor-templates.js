export default function templateManager(config) {
    return {
        showDrawer: false,
        isEditing: false,
        showDeleteModal: false,
        deleteId: null,
        
        formAction: config.storeRoute,
        formMethod: 'POST',

        // Updated keys to match DB column names exactly
        formData: {
            id: '',
            template_name: '',
            subjective_text: '',
            objective_text: '',
            assessment_text: '',
            plan_text: ''
        },
        
        openDrawer(mode, template = null) {
            this.isEditing = mode === 'edit';
            
            if (this.isEditing && template) {
                this.formData = { ...template };
                this.formAction = `/doctor/templates/${template.id}`;
                this.formMethod = 'PATCH';
            } else {
                this.formData = {
                    id: '', 
                    template_name: '',
                    subjective_text: '', 
                    objective_text: '', 
                    assessment_text: '', 
                    plan_text: ''
                };
                this.formAction = config.storeRoute;
                this.formMethod = 'POST';
            }
            
            this.showDrawer = true;
        },

        duplicateTemplate(template) {
            this.isEditing = false;
            this.formData = { ...template, id: '', template_name: template.template_name + ' (Copy)' };
            this.formAction = config.storeRoute;
            this.formMethod = 'POST';
            this.showDrawer = true;
        },

        confirmDelete(id) {
            this.deleteId = id;
            this.showDeleteModal = true;
        },

        resizeTextarea(e) {
            let el = e.target;
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        }
    };
}