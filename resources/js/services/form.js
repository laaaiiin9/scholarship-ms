import { showToast } from "../utils/toast";
import { getErrorMessage } from "../helpers/getErrMsg";

document.addEventListener('submit', async (e) => {
    const form = e.target;

    // Only process forms marked with data-ajax-form
    if (!form.matches('[data-ajax-form]')) return;

    e.preventDefault();

    const submitBtn = form.querySelector('[type="submit"]');
    const originalHtml = submitBtn ? submitBtn.innerHTML : null;

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add('disabled');
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...';
    }

    // Clear previous errors
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    form.querySelectorAll('.invalid-feedback.ajax-error').forEach(el => el.remove());

    try {
        const res = await fetch(form.action, {
            method: form.method || 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (res.ok) {
            if (data.redirect) {
                // If there's a redirect, prioritize it
                window.location.href = data.redirect;
            } else {
                if (data.message) showToast(data.message, 'success');
                if (form.matches('[data-reset-on-success]')) {
                    form.reset();
                }
            }
        } else {
            // Handle Laravel Validation Errors (422)
            if (res.status === 422 && data.errors) {
                Object.keys(data.errors).forEach(field => {
                    // Find input element (handle array names too)
                    const input = form.querySelector(`[name="${field}"], [name="${field}[]"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback ajax-error';
                        errorDiv.innerText = data.errors[field][0]; // Show first error
                        
                        // Append logic based on form groups or append directly
                        if (input.nextElementSibling && input.nextElementSibling.tagName === 'LABEL') {
                            // Floating labels pattern
                            input.parentNode.appendChild(errorDiv);
                        } else if (input.parentNode.classList.contains('input-group')) {
                            input.parentNode.parentNode.appendChild(errorDiv);
                        } else {
                            input.parentNode.appendChild(errorDiv);
                        }
                    }
                });
                showToast('Please correct the highlighted errors.', 'error');
            } else {
                // General backend error format fallback
                showToast(data.message || data.error || 'An error occurred during submission.', 'error');
            }
        }
    } catch (err) {
        showToast(getErrorMessage(err) ?? 'A network error occurred!', 'error');
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            submitBtn.innerHTML = originalHtml;
        }
    }
});
