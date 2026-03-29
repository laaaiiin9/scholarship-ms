import { post } from '../../services/api';
import { showToast } from '../../utils/toast';
import { getErrorMessage } from '../../helpers/errorMsg';

const form = document.querySelector('#loginForm');

if (form) {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');

        if (submitButton) {
            submitButton.disabled = true;
        }

        try {
            const res = await post(form.action, formData);

            showToast(res.msg ?? 'Login successful.', 'success');
            form.reset();

            if (res.redirect) {
                setTimeout(() => {
                    window.location.href = res.redirect;
                }, 500);
            }
            
        } catch (err) {
            showToast(getErrorMessage(err), 'error');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
            }
        }
    });
}
