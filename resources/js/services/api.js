import { showToast } from "../utils/toast";
import { getErrorMessage } from "../helpers/getErrMsg";

document.addEventListener('submit', async (e) => {
    const form = e.target;

    if (!form.matches('[data-ajax-form]')) return;

    e.preventDefault();

    const submitBtn = form.querySelector('[type="submit"]');
    const originalText = submitBtn?.innerText;

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerText = 'Loading...';
        submitBtn.classList.add('disabled');
    }

    try {
        const res = await fetch(form.action, {
            method: form.method,
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        console.log(res);

        const data = await res.json();

        console.log(data);

        if (res.ok) {
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 200);
            }

            console.log(data.message);

            showToast(data.message);
        } else {
            showToast(getErrorMessage(err) ?? 'Error!', 'error')
        }

    } catch (err) {
        showToast(getErrorMessage(err) ?? 'Error!', 'error')
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerText = originalText;
            submitBtn.classList.remove('disabled');
        }
    }
});