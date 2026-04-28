/**
 * Simple Scroll Animation Module
 * Uses Intersection Observer to add/remove classes when elements enter viewport.
 */
export function initScrollAnimations() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                // Optional: stop observing once animation is triggered
                // observer.unobserve(entry.target);
            } else {
                // Remove class if you want animation to re-trigger when scrolling back up
                entry.target.classList.remove('animate-in');
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll('.scroll-animate');
    animatedElements.forEach(el => observer.observe(el));
}
