import * as bootstrap from 'bootstrap';
import { showToast } from '../../utils/toast';

export default class FormService {
    constructor({ formId, saveBtnId, modalId, buildUrl, onSaved }) {
        this.form = document.getElementById(formId);
        this.saveBtn = document.getElementById(saveBtnId);
        this.modalEl = document.getElementById(modalId);
        this.modal = this.modalEl ? bootstrap.Modal.getOrCreateInstance(this.modalEl) : null;
        this.buildUrl = buildUrl; // function(formData) => returns { url, isEdit }
        this.onSaved = onSaved;

        this.init();
    }

    init() {
        if (this.saveBtn && this.form) {
            this.saveBtn.addEventListener('click', async () => {
                await this.submit();
            });
        }
    }

    async submit() {
        if (!this.form.checkValidity()) {
            this.form.reportValidity();
            return;
        }

        const formData = new FormData(this.form);
        const { url, isEdit } = typeof this.buildUrl === 'function' ? this.buildUrl(formData) : { url: this.form.action, isEdit: false };
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        this.saveBtn.disabled = true;
        const originalBtnHtml = this.saveBtn.innerHTML;
        this.saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    let errorMessage = data.message || "Validation failed";
                    if (data.errors) {
                        const firstErrorError = Object.values(data.errors)[0][0];
                        errorMessage = firstErrorError;
                    }
                    throw new Error(errorMessage);
                }
                throw new Error(data.message || "An error occurred");
            }

            if (this.modal) {
                this.modal.hide();
            }
            
            if (this.onSaved) {
                this.onSaved(data);
            }
            
            showToast(data.msg || "Saved successfully.", 'success');
        } catch (error) {
            console.error("Error saving form", error);
            showToast(error.message || "An error occurred while saving.", 'error');
        } finally {
            this.saveBtn.disabled = false;
            this.saveBtn.innerHTML = originalBtnHtml;
        }
    }
    
    static async fetchForEdit(url) {
        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!response.ok) throw new Error('Failed to fetch data');
            return await response.json();
        } catch (error) {
            console.error("Error fetching details", error);
            showToast("Failed to fetch details.", 'error');
            return null;
        }
    }

    static async deleteRecord(url, onSuccess) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || "Failed to delete");
            }
            
            showToast(data.msg || "Deleted successfully.", 'success');
            if (onSuccess) onSuccess();
            return true;
        } catch(error) {
            console.error("Error deleting", error);
            showToast(error.message || "Failed to delete record.", 'error');
            return false;
        }
    }
}
