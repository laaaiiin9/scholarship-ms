import { post } from '../../services/api';
import { showToast } from '../../utils/toast';
import { getErrorMessage } from '../../helpers/errorMsg';
import { setupSubmitButtonLoading } from '../../helpers/submitButtonLoading';

const form = document.querySelector('#profileForm');

if (form) {
    const submitButton = form.querySelector('#btn-submit');
    const buttonState = setupSubmitButtonLoading(submitButton, 'Save Profile', 'Saving...');

    if (buttonState) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            buttonState.start();

            const formData = new FormData(form);

            try {
                const res = await post(form.action, formData);

                showToast(res.msg);
                //form.reset();

                if (res.redirect) {
                    setTimeout(() => {
                        window.location.href = res.redirect;
                    }, 500);
                }

            } catch (err) {
                showToast(getErrorMessage(err), 'error');
            } finally {
                buttonState.stop();
            }
        });
    }
}
