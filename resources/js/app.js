import './bootstrap';
import 'bootstrap';
import { createIcons, icons } from 'lucide';
import './modules/auth/register';
import './modules/auth/login';
import './modules/auth/logout';
import './modules/student/profile';
import './modules/email/sendVerification';
import './modules/public/scholarships';

createIcons({ icons });

const root = document.documentElement;
const themeToggle = document.querySelector('#theme-toggle');

if (themeToggle) {
    const themeToggleIcon = themeToggle.querySelector('.theme-toggle-icon');

    const applyTheme = (theme) => {
        root.setAttribute('data-theme', theme);
        root.style.colorScheme = theme;
        localStorage.setItem('theme', theme);

        const isDark = theme === 'dark';
        themeToggle.setAttribute('aria-pressed', String(!isDark));
        themeToggle.setAttribute('aria-label', isDark ? 'Switch to light theme' : 'Switch to dark theme');

        if (themeToggleIcon) {
            themeToggleIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
            createIcons({ icons });
        }
    };

    const initialTheme = root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
    applyTheme(initialTheme);

    themeToggle.addEventListener('click', () => {
        const nextTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        applyTheme(nextTheme);
    });
}

const navbarToggler = document.querySelector('#navbar-toggler');
const navbarCollapse = document.querySelector('#navbarTogglerDemo01');

if (navbarToggler && navbarCollapse) {
    const renderTogglerIcon = (iconName) => {
        navbarToggler.innerHTML = `<span data-lucide="${iconName}"></span>`;
        createIcons({ icons });
    };

    navbarCollapse.addEventListener('show.bs.collapse', () => {
        renderTogglerIcon('x');
    });

    navbarCollapse.addEventListener('hide.bs.collapse', () => {
        renderTogglerIcon('menu');
    });

    if (navbarCollapse.classList.contains('show')) {
        renderTogglerIcon('x');
    } else {
        renderTogglerIcon('menu');
    }
}
