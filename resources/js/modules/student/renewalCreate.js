import { showToast } from '../../utils/toast';

/**
 * Student Renewal Create Page Module
 * Handles the renewal form submission with file uploads.
 */
document.addEventListener('DOMContentLoaded', function () {
    const renewalForm = document.getElementById('renewalForm');
    const submitBtn   = document.getElementById('submitRenewalBtn');

    if (!renewalForm || !submitBtn) return;

    renewalForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Submitting...';

        try {
            const formData = new FormData();

            // CSRF
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfMeta) formData.append('_token', csrfMeta.getAttribute('content'));

            // Hidden fields
            const appId    = renewalForm.querySelector('[name="application_id"]');
            const periodId = renewalForm.querySelector('[name="renewal_period_id"]');
            if (appId)    formData.append('application_id', appId.value);
            if (periodId) formData.append('renewal_period_id', periodId.value);

            // File inputs — explicit per requirement ID
            renewalForm.querySelectorAll('input[type="file"]').forEach(function (input) {
                if (input.files && input.files.length > 0) {
                    const match = input.name.match(/requirements\[(\d+)\]/);
                    if (match) {
                        formData.append('requirements[' + match[1] + ']', input.files[0], input.files[0].name);
                    }
                }
            });

            const renewalStoreUrl = renewalForm.dataset.storeUrl;
            const response = await fetch(renewalStoreUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                    // DO NOT set Content-Type — browser sets it with the multipart boundary
                }
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message || 'Renewal submitted successfully!', 'success');
                setTimeout(function () {
                    window.location.href = data.redirect || '/student/renewals';
                }, 1500);
            } else {
                showToast(data.message || 'Submission failed. Please try again.', 'error');
                submitBtn.disabled  = false;
                submitBtn.innerHTML = originalHtml;
            }
        } catch (error) {
            console.error('Renewal submission error:', error);
            showToast('Network error. Please try again.', 'error');
            submitBtn.disabled  = false;
            submitBtn.innerHTML = originalHtml;
        }
    });
});
