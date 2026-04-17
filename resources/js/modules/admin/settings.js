import { createIcons, icons } from 'lucide';
import { showToast } from '../../utils/toast';

document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('settingsForm');
    if (!form) return;

    createIcons({ icons });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = document.getElementById('saveSettingsBtn');
        const originalHtml = btn.innerHTML;

        // Toggle handling
        const registrationHidden = document.getElementById('registration_enabled_hidden');
        const maintenanceHidden = document.getElementById('maintenance_mode_hidden');
        
        // If checkboxes are unchecked, the hidden inputs with value 0 will be sent
        // If checked, the checkboxes with value 1 will OVERRIDE because they come after (standard form behavior for same names)
        // Actually, better to just check state:
        const regCheck = form.querySelector('input[name="registration_enabled"][type="checkbox"]');
        registrationHidden.disabled = regCheck.checked;
        
        const mainCheck = form.querySelector('input[name="maintenance_mode"][type="checkbox"]');
        maintenanceHidden.disabled = mainCheck.checked;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        try {
            const response = await fetch('/admin/settings/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showToast(result.message, 'success');
                // Refresh page after a short delay to apply global site name/color changes if implemented
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast(result.message || 'An error occurred.', 'error');
            }
        } catch (error) {
            console.error('Settings update error:', error);
            showToast('Network error while updating settings.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    });

});
