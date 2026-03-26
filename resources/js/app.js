import './bootstrap';
import 'bootstrap';
import { createIcons, icons } from 'lucide';

createIcons({ icons });

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