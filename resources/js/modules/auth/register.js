import { post } from '../../services/api';
import { showToast } from '../../utils/toast';

const form = document.querySelector('#registerForm');

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

            showToast(res.msg ?? 'Registration successful.', 'success');
            form.reset();
        } catch (err) {
            if (err.errors) {
                const firstError = Object.values(err.errors).flat()[0];
                showToast(firstError ?? 'Please check the form and try again.', 'error');
            } else {
                showToast(err.msg ?? 'Registration failed. Please try again.', 'error');
            }
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
            }
        }
    });
}
