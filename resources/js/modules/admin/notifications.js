import { TableService } from '../../services/table.js';
import { FormService } from '../../services/form.js';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Table Logic
    const tableBody = document.getElementById('notifications-table-body');
    const paginationContainer = document.getElementById('pagination-container');
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');

    const tableService = new TableService('/admin/notifications', tableBody, paginationContainer);

    tableService.setRenderCallback((notifications) => {
        if (notifications.length === 0) {
            return `<tr><td colspan="4" class="text-center py-5 text-muted">No notifications found matching your criteria.</td></tr>`;
        }

        return notifications.map(n => {
            const typeColor = n.type === 'ALERT' ? 'danger' : (n.type === 'ANNOUNCEMENT' ? 'primary' : 'info');
            const targetLabel = n.user_id 
                ? `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill">${n.user.profile.first_name} ${n.user.profile.last_name}</span>`
                : `<span class="badge bg-body-secondary text-muted border px-2 py-1 rounded-pill">Broadcast</span>`;

            return `
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-start gap-3">
                            <div class="avatar-circle sm bg-${typeColor}-subtle text-${typeColor} mt-1">
                                <i data-lucide="${n.type === 'ALERT' ? 'alert-triangle' : (n.type === 'ANNOUNCEMENT' ? 'megaphone' : 'bell')}" style="width: 14px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold text-body">${n.title}</h6>
                                <p class="mb-0 text-muted small text-truncate" style="max-width: 300px;">${n.message}</p>
                            </div>
                        </div>
                    </td>
                    <td>${targetLabel}</td>
                    <td class="text-muted small">${new Date(n.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-icon btn-outline-danger border-0 rounded-3 delete-btn" data-id="${n.id}" title="Delete Notification">
                            <i data-lucide="trash-2" style="width: 14px;"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    });

    tableService.init();

    // Filters
    searchInput.addEventListener('input', (e) => {
        tableService.setFilter('search', e.target.value);
    });

    typeFilter.addEventListener('change', (e) => {
        tableService.setFilter('type', e.target.value);
    });

    // 2. Form Logic
    const composeForm = document.getElementById('composeForm');
    const sendBtn = document.getElementById('sendNotificationBtn');
    const composeModalEl = document.getElementById('composeModal');
    const composeModal = bootstrap.Modal.getOrCreateInstance(composeModalEl);

    const formService = new FormService(composeForm, sendBtn);

    formService.setSuccessCallback((response) => {
        composeModal.hide();
        composeForm.reset();
        tableService.fetchData(); // Refresh history
        
        if (window.Toast) {
            window.Toast.success(response.message || 'Notification sent!');
        }
    });

    sendBtn.addEventListener('click', () => {
        formService.submit('/admin/notifications/store', 'POST');
    });

    // 3. Delete Logic
    tableBody.addEventListener('click', async (e) => {
        const deleteBtn = e.target.closest('.delete-btn');
        if (!deleteBtn) return;

        if (!confirm('Are you sure you want to delete this notification record?')) return;

        try {
            const response = await fetch(`/admin/notifications/${deleteBtn.dataset.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                tableService.fetchData();
                if (window.Toast) window.Toast.success('Record deleted.');
            }
        } catch (error) {
            console.error('Error deleting:', error);
        }
    });

    // Handle scope radio changes
    const scopeRadios = composeForm.querySelectorAll('input[name="scope"]');
    const studentWrapper = document.getElementById('studentSelectWrapper');
    scopeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'individual') {
                studentWrapper.classList.remove('d-none');
            } else {
                studentWrapper.classList.add('d-none');
            }
        });
    });
});
