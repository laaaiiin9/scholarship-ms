export function initCookieConsent() {
    const banner = document.getElementById('cookie-consent');
    const acceptBtn = document.getElementById('accept-cookies');

    if (!banner || !acceptBtn) return;

    // Check if user already accepted
    const isAccepted = localStorage.getItem('cookies-accepted');

    if (!isAccepted) {
        // Show banner with a slight delay
        setTimeout(() => {
            banner.classList.remove('opacity-0', 'translate-middle-y');
            banner.style.pointerEvents = 'all';
        }, 2000);
    }

    acceptBtn.addEventListener('click', () => {
        localStorage.setItem('cookies-accepted', 'true');
        banner.classList.add('opacity-0', 'translate-middle-y');
        banner.style.pointerEvents = 'none';
        
        // Optional: show a small toast
        if (window.showToast) {
            window.showToast('Preferences saved!', 'success');
        }
    });
}
