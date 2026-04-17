import { createIcons, icons } from 'lucide';
import { showToast } from '../../utils/toast';

document.addEventListener('DOMContentLoaded', () => {
    
    // Initialize icons if any were dynamically added
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    const form = document.getElementById('applicationForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = document.getElementById('submitBtn');
        const originalHtml = btn.innerHTML;
        
        // Locking state
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Uploading...';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const formData = new FormData(form);

        try {
            const response = await fetch('/student/applications', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData // Note: no Content-Type set manually; fetch handles boundary generation.
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 401 || response.status === 403) {
                    window.location.href = '/login';
                    return;
                }

                let errorMessage = data.message || "Failed to submit application process.";
                if (response.status === 422 && data.errors) {
                    errorMessage = Object.values(data.errors)[0][0] || errorMessage;
                }
                throw new Error(errorMessage);
            }

            showToast(data.msg || "Successfully submitted framework documents!", 'success');
            
            // Redirect smoothly to dashboard instead of grid
            setTimeout(() => {
                window.location.href = '/student/dashboard';
            }, 1500);

        } catch (error) {
            console.error("Error applying framework block", error);
            showToast(error.message || "A constraint error occurred. Minimum data required.", 'error');
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    });

});
