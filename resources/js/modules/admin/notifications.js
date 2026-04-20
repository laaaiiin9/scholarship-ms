import * as bootstrap from 'bootstrap';
import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';
import { showToast } from '../../utils/toast';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Table Logic
    const tableService = new TableService({
        tableBodyId: 'notifications-table-body',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/notifications',
        renderRow: (n) => {
            const typeColor = n.type === 'ALERT' ? 'danger' : (n.type === 'ANNOUNCEMENT' ? 'primary' : 'info');
            const typeIcon  = n.type === 'ALERT' ? 'alert-triangle' : (n.type === 'ANNOUNCEMENT' ? 'megaphone' : 'bell');

            const targetLabel = n.user_id
                ? `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill">${n.user?.profile?.first_name ?? ''} ${n.user?.profile?.last_name ?? n.user?.email ?? 'Student'}</span>`
                : `<span class="badge bg-body-secondary text-muted border px-2 py-1 rounded-pill">Broadcast</span>`;

            const date = new Date(n.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

            return `
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-start gap-3">
                            <div class="avatar-circle sm bg-${typeColor}-subtle text-${typeColor} mt-1">
                                <i data-lucide="${typeIcon}" style="width: 14px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold text-body">${n.title ?? '(No Title)'}</h6>
                                <p class="mb-0 text-muted small text-truncate" style="max-width: 300px;">${n.message}</p>
                            </div>
                        </div>
                    </td>
                    <td>${targetLabel}</td>
                    <td class="text-muted small">${date}</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-icon btn-outline-danger border-0 rounded-3 delete-notif-btn" data-id="${n.id}" title="Delete">
                            <i data-lucide="trash-2" style="width: 14px;"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });

    // 2. Search/Type filter
    const typeFilter = document.getElementById('typeFilter');
    if (typeFilter) {
        typeFilter.addEventListener('change', (e) => {
            tableService.setExtraParams({ type: e.target.value });
        });
    }

    // 3. Delete handler (event delegation)
    const tableBody = document.getElementById('notifications-table-body');
    if (tableBody) {
        tableBody.addEventListener('click', async (e) => {
            const btn = e.target.closest('.delete-notif-btn');
            if (!btn) return;
            if (!confirm('Delete this notification record?')) return;

            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch(`/admin/notifications/${btn.dataset.id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            });

            if (res.ok) {
                tableService.fetchData();
                showToast('Notification deleted.', 'success');
            } else {
                showToast('Failed to delete notification.', 'error');
            }
        });
    }

    // 4. Compose Form
    const composeForm  = document.getElementById('composeForm');
    const sendBtn      = document.getElementById('sendNotificationBtn');
    const composeModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('composeModal'));

    if (sendBtn && composeForm) {
        const formService = new FormService({
            formId: 'composeForm',
            saveBtnId: 'sendNotificationBtn',
            modalId: 'composeModal',
            buildUrl: () => ({ url: '/admin/notifications/store', isEdit: false }),
            onSaved: () => {
                composeForm.reset();
                document.getElementById('studentSelectWrapper')?.classList.add('d-none');
                tableService.fetchData();
                showToast('Notification sent!', 'success');
            }
        });
    }

    // 5. Scope radio toggle
    const scopeRadios      = document.querySelectorAll('input[name="scope"]');
    const studentWrapper   = document.getElementById('studentSelectWrapper');
    scopeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (studentWrapper) {
                studentWrapper.classList.toggle('d-none', radio.value !== 'individual');
            }
        });
    });
});
