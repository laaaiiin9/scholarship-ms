import { post } from '../../services/api';
import { showToast } from '../../utils/toast';
import { getErrorMessage } from '../../helpers/errorMsg';
import { setupSubmitButtonLoading } from '../../helpers/submitButtonLoading';

const form = document.querySelector('#registerForm');

if (form) {
    const submitButton = form.querySelector('button[type="submit"]');
    const buttonState = setupSubmitButtonLoading(submitButton, 'Create Account', 'Creating account...');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        buttonState?.start();

        try {
            const res = await post(form.action, formData);

            showToast(res.msg ?? 'Registration successful.', 'success');
            form.reset();

            if (res.redirect) {
                setTimeout(() => {
                    window.location.href = res.redirect;
                }, 500);
            }

        } catch (err) {
            showToast(getErrorMessage(err), 'error');
        } finally {
            buttonState?.stop();
        }
    });
}
