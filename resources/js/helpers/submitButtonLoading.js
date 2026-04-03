export function setupSubmitButtonLoading(submitButton, fallbackDefaultText = 'Submit', fallbackLoadingText = 'Submitting...') {
    if (!submitButton) {
        return null;
    }

    const defaultText = submitButton.dataset.defaultText ?? fallbackDefaultText;
    const loadingText = submitButton.dataset.loadingText ?? fallbackLoadingText;

    const btnSpinner = document.createElement('span');
    const btnStatus = document.createElement('span');

    btnSpinner.classList.add('spinner-border', 'spinner-border-sm', 'me-2');
    btnSpinner.setAttribute('aria-hidden', 'true');
    btnSpinner.style.display = 'none';

    btnStatus.setAttribute('role', 'status');
    btnStatus.textContent = defaultText;

    submitButton.textContent = '';
    submitButton.append(btnSpinner, btnStatus);

    return {
        start() {
            submitButton.disabled = true;
            submitButton.setAttribute('aria-busy', 'true');
            btnSpinner.style.display = 'inline-block';
            btnStatus.textContent = loadingText;
        },
        stop() {
            submitButton.disabled = false;
            submitButton.removeAttribute('aria-busy');
            btnSpinner.style.display = 'none';
            btnStatus.textContent = defaultText;
        },
    };
}
