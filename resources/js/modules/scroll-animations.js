/**
 * Simple Scroll Animation Module
 * Uses Intersection Observer to add/remove classes when elements enter viewport.
 */
export function initScrollAnimations() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll('.scroll-animate').forEach(el => el.classList.add('animate-in'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll('.scroll-animate');
    animatedElements.forEach(el => observer.observe(el));
}
