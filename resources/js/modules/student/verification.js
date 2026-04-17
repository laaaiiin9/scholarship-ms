import { showToast } from '../../utils/toast';

document.addEventListener('DOMContentLoaded', () => {
    const resendBtn = document.getElementById('resendVerificationBtn');
    const resendBtnMain = document.getElementById('resendVerificationBtnMain');
    
    if (!resendBtn && !resendBtnMain) return;

    const handleResend = async (btn) => {
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Sending...';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        try {
            const response = await fetch('/email/verify/notification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                showToast('Verification email has been resent!', 'success');
            } else {
                const data = await response.json();
                showToast(data.message || 'Failed to resend. Please try again later.', 'error');
            }
        } catch (error) {
            console.error('Verification resend error:', error);
            showToast('Network error while resending verification.', 'error');
        } finally {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    };

    if (resendBtn) resendBtn.addEventListener('click', () => handleResend(resendBtn));
    if (resendBtnMain) resendBtnMain.addEventListener('click', () => handleResend(resendBtnMain));
});
