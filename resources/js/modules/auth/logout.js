import { post } from '../../services/api';
import { showToast } from '../../utils/toast';
import { getErrorMessage } from '../../helpers/errorMsg';

const btn = document.querySelector('#btn-logout');

if (btn) {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();

        btn.disabled = true;
        const link = e.currentTarget.getAttribute('href');

        try {
            const res = await post(link, new FormData());

            showToast(res.msg ?? 'Logout successful.', 'success');

            if (res.redirect) {
                setTimeout(() => {
                    window.location.href = res.redirect;
                }, 500);
            }

        } catch (err) {
            //console.log(err);
            showToast(getErrorMessage(err), 'error');
        } finally {
            btn.disabled = false;
        }
    });
}
