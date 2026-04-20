import { createIcons, icons } from 'lucide';

/**
 * Notification Bell Module
 * Polls unread count and populates dropdown on every page load.
 */
(function initNotificationBell() {
    const badge     = document.getElementById('notif-badge');
    const listEl    = document.getElementById('notif-dropdown-list');
    const markAllBtn = document.getElementById('notif-mark-all-btn');

    if (!badge && !listEl) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    async function fetchCount() {
        try {
            const res  = await fetch('/notifications/unread-count', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            const count = data.count ?? 0;

            if (badge) {
                badge.textContent = count > 9 ? '9+' : count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        } catch (_) {}
    }

    async function fetchRecent() {
        if (!listEl) return;
        try {
            const res   = await fetch('/notifications/recent', { headers: { 'Accept': 'application/json' } });
            const items = await res.json();

            if (!items.length) {
                listEl.innerHTML = `<li class="px-3 py-4 text-center text-muted small">No notifications yet.</li>`;
                return;
            }

            listEl.innerHTML = items.map(n => {
                const typeIcon  = n.type === 'ALERT' ? 'alert-triangle' : (n.type === 'ANNOUNCEMENT' ? 'megaphone' : 'bell');
                const typeColor = n.type === 'ALERT' ? 'danger' : (n.type === 'ANNOUNCEMENT' ? 'primary' : 'info');
                const readClass = n.is_read ? 'opacity-50' : '';
                const dot       = n.is_read ? '' : `<span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle" style="width:8px;height:8px;"></span>`;

                return `
                    <li class="notif-item ${readClass}" data-id="${n.id}" style="cursor:pointer;">
                        <div class="d-flex align-items-start gap-3 px-3 py-3 border-bottom border-opacity-10" style="transition: background 0.15s;">
                            <div class="position-relative">
                                <div class="avatar-circle sm bg-${typeColor}-subtle text-${typeColor} flex-shrink-0">
                                    <i data-lucide="${typeIcon}" style="width:14px;"></i>
                                </div>
                                ${dot}
                            </div>
                            <div class="overflow-hidden">
                                <p class="mb-0 fw-semibold text-body" style="font-size:0.82rem;">${n.title ?? 'Notification'}</p>
                                <p class="mb-0 text-muted text-truncate" style="font-size:0.75rem;max-width:200px;">${n.message}</p>
                            </div>
                        </div>
                    </li>
                `;
            }).join('');

            createIcons({ icons });

            // Clicking an item marks it as read
            listEl.querySelectorAll('.notif-item').forEach(item => {
                item.addEventListener('click', async () => {
                    const id = item.dataset.id;
                    await fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                    });
                    item.classList.add('opacity-50');
                    item.querySelector('.bg-danger')?.remove();
                    fetchCount();
                });
            });

        } catch (_) {}
    }

    // Mark All Read
    if (markAllBtn) {
        markAllBtn.addEventListener('click', async () => {
            await fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            });
            fetchCount();
            listEl?.querySelectorAll('.notif-item').forEach(i => {
                i.classList.add('opacity-50');
                i.querySelector('.bg-danger')?.remove();
            });
        });
    }

    fetchCount();
    fetchRecent();
})();
