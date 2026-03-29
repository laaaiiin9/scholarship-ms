import { Toast } from 'bootstrap';

const TOAST_CONTAINER_ID = 'appToastContainer';

const ensureContainer = () => {
    let container = document.getElementById(TOAST_CONTAINER_ID);

    if (container) {
        return container;
    }

    container = document.createElement('div');
    container.id = TOAST_CONTAINER_ID;
    container.className = 'toast-container position-fixed top-0 end-0 p-3 app-toast-container';
    container.setAttribute('aria-live', 'polite');
    container.setAttribute('aria-atomic', 'true');

    document.body.appendChild(container);

    return container;
};

export function showToast(message, type = 'success') {
    const container = ensureContainer();
    const toast = document.createElement('div');
    const variantClass = type === 'error' ? 'text-bg-danger' : 'text-bg-success';

    toast.className = `toast align-items-center border-0 ${variantClass}`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button
                type="button"
                class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"
                aria-label="Close"
            ></button>
        </div>
    `;

    container.appendChild(toast);

    const instance = new Toast(toast, {
        autohide: true,
        delay: type === 'error' ? 5000 : 3500,
    });

    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    }, { once: true });

    instance.show();
}
