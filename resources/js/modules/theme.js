import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    const themeSwitches = document.querySelectorAll('.theme-switch');
    const themeToggles = document.querySelectorAll('.theme-toggle');
    const activeIcons = document.querySelectorAll('.theme-icon-active');
    
    if (!themeSwitches.length && !themeToggles.length) return;

    // Apply currently stored theme to UI icons
    const currentTheme = localStorage.getItem('theme') || 'dark';
    updateActiveIcon(currentTheme);

    themeSwitches.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const theme = e.currentTarget.getAttribute('data-theme-value');
            applyTheme(theme);
        });
    });

    themeToggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
        });
    });

    function applyTheme(theme) {
        // Set data attribute
        document.documentElement.setAttribute('data-bs-theme', theme);
        
        // Store preference
        localStorage.setItem('theme', theme);
        
        // Update icon visually
        updateActiveIcon(theme);
    }

    function updateActiveIcon(theme) {
        activeIcons.forEach(icon => {
            const newIconName = theme === 'light' ? 'sun' : 'moon';
            
            if (icon.tagName.toLowerCase() === 'svg') {
                const newI = document.createElement('i');
                newI.setAttribute('data-lucide', newIconName);
                newI.className = 'theme-icon-active';
                newI.style.width = icon.getAttribute('width') || '18px';
                newI.style.height = icon.getAttribute('height') || '18px';
                icon.replaceWith(newI);
            } else {
                icon.setAttribute('data-lucide', newIconName);
            }
        });
        
        // Re-render new icons
        createIcons({ icons });
    }
});
