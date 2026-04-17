import { createIcons, icons } from 'lucide';
import { showToast } from '../../utils/toast';

document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('profileForm');
    if (!form) return;

    createIcons({ icons });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = document.getElementById('submitBtn');
        const originalHtml = btn.innerHTML;

        // Validation (Basic)
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        try {
            const response = await fetch('/student/profile/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showToast(result.message, 'success');
                // Optional: Update some UI elements if needed
            } else {
                let errorMsg = result.message || 'An error occurred while updating profile.';
                if (result.errors) {
                    errorMsg = Object.values(result.errors)[0][0];
                }
                showToast(errorMsg, 'error');
            }
        } catch (error) {
            console.error('Profile update error:', error);
            showToast('Network error while updating profile.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            createIcons({ icons });
        }
    });

});
