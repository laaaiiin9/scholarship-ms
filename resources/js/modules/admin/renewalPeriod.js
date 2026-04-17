import * as bootstrap from 'bootstrap';
import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Table Service
    const tableService = new TableService({
        tableBodyId: 'renewal-periods-table-body',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/renewal-periods/list',
        renderRow: (item) => {
            const scholarshipName = item.scholarship ? item.scholarship.name : 'Unknown Scholarship';

            // Format Badge colors
            let statusBadge = '';
            switch (item.status) {
                case 'OPEN':
                    statusBadge = `<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Open Phase</span>`;
                    break;
                case 'CLOSED':
                    statusBadge = `<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">Closed Phase</span>`;
                    break;
                default:
                    statusBadge = `<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">${item.status}</span>`;
            }

            return `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle sm bg-primary-subtle text-eskoylar-primary border border-primary-subtle">
                                <i data-lucide="refresh-cw" style="width: 18px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold text-body">${scholarshipName}</h6>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small">${new Date(item.start_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</td>
                    <td class="text-muted small">${new Date(item.end_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</td>
                    <td>${statusBadge}</td>
                    <td class="pe-4 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm btn-outline-eskoylar-primary btn-icon shadow-sm" title="Edit" onclick="window.editPeriod(${item.id})">
                                <i data-lucide="pencil" style="width: 16px;"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-icon shadow-sm" title="Delete" onclick="window.deletePeriod(${item.id})">
                                <i data-lucide="trash" style="width: 16px;"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }
    });

    // 2. Initialize Form Service
    const formService = new FormService({
        formId: 'periodForm',
        saveBtnId: 'savePeriodBtn',
        modalId: 'periodModal',
        buildUrl: (formData) => {
            const id = formData.get('id');
            if (id) {
                return { url: `/admin/renewal-periods/update/${id}`, isEdit: true };
            }
            return { url: '/admin/renewal-periods/store', isEdit: false };
        },
        onSaved: () => {
            tableService.fetchData();
        }
    });

    // Modal Cleanup Event
    const periodModal = document.getElementById('periodModal');
    if (periodModal) {
        periodModal.addEventListener('hidden.bs.modal', () => {
            document.getElementById('periodForm').reset();
            document.getElementById('period_id').value = '';
            document.getElementById('periodModalLabel').innerText = 'New Renewal Period';
        });
    }

    // 3. Expose Global Edit & Delete Handlers
    window.editPeriod = async (id) => {
        const data = await FormService.fetchForEdit(`/admin/renewal-periods/fetch/${id}`);
        if (data) {
            document.getElementById('period_id').value = data.id;
            document.getElementById('scholarship_id').value = data.scholarship_id;

            // Format dates simply for html5 date input (YYYY-MM-DD): The API may return ISO strings
            const startDate = data.start_date ? data.start_date.split('T')[0] : '';
            const endDate = data.end_date ? data.end_date.split('T')[0] : '';

            document.getElementById('start_date').value = startDate;
            document.getElementById('end_date').value = endDate;
            document.getElementById('status').value = data.status;

            document.getElementById('periodModalLabel').innerText = 'Edit Renewal Period';
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('periodModal'));
            modal.show();
        }
    };

    let deleteId = null;
    window.deletePeriod = (id) => {
        deleteId = id;
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('deletePeriodModal'));
        modal.show();
    };

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', async () => {
            if (!deleteId) return;
            const originalHtml = confirmDeleteBtn.innerHTML;
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';

            const success = await FormService.deleteRecord(`/admin/renewal-periods/delete/${deleteId}`, () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deletePeriodModal'));
                if (modal) modal.hide();
                tableService.fetchData();
            });

            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.innerHTML = originalHtml;
            if (success) deleteId = null;
        });
    }
});
