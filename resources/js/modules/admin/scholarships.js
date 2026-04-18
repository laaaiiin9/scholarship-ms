import * as bootstrap from 'bootstrap';
import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Table Service
    const tableService = new TableService({
        tableBodyId: 'scholarships-table-body',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/scholarships',
        renderRow: (item) => {
            const maxAmount = item.max_amount ? parseFloat(item.max_amount) : 0;
            const amountFormatted = `$${maxAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

            return `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle sm bg-primary-subtle text-eskoylar-primary">
                                <i data-lucide="graduation-cap" style="width: 18px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold text-body">${item.name}</h6>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">
                        <span class="d-inline-block text-truncate" style="max-width: 250px;">${item.description || 'No description'}</span>
                    </td>
                    <td class="fw-medium text-body">${amountFormatted}</td>
                    <td class="text-muted">
                        ${item.created_by}
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm btn-outline-secondary btn-icon shadow-sm" title="View Details" onclick="window.viewScholarship(${item.id})">
                                <i data-lucide="eye" style="width: 16px;"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-eskoylar-primary btn-icon shadow-sm" title="Edit" onclick="window.editScholarship(${item.id})">
                                <i data-lucide="pencil" style="width: 16px;"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-icon shadow-sm" title="Delete" onclick="window.deleteScholarship(${item.id})">
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
        formId: 'scholarshipForm',
        saveBtnId: 'saveScholarshipBtn',
        modalId: 'scholarshipModal',
        buildUrl: (formData) => {
            const id = formData.get('id');
            if (id) {
                return { url: `/admin/scholarships/${id}`, isEdit: true };
            }
            return { url: '/admin/scholarships/store', isEdit: false };
        },
        onSaved: () => {
            tableService.fetchData();
        }
    });

    // Modal Cleanup Event
    const scholarshipModal = document.getElementById('scholarshipModal');
    if (scholarshipModal) {
        scholarshipModal.addEventListener('hidden.bs.modal', () => {
            document.getElementById('scholarshipForm').reset();
            document.getElementById('scholarship_id').value = '';
            document.getElementById('scholarshipModalLabel').innerText = 'New Scholarship';
        });
    }

    // 3. Expose Global Edit & Delete Handlers
    window.viewScholarship = (id) => {
        console.log("View", id);
    };

    window.editScholarship = async (id) => {
        const data = await FormService.fetchForEdit(`/admin/scholarships/${id}/edit`);
        if (data) {
            document.getElementById('scholarship_id').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description || '';
            document.getElementById('max_amount').value = data.max_amount;
            
            document.getElementById('scholarshipModalLabel').innerText = 'Edit Scholarship';
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('scholarshipModal'));
            modal.show();
        }
    };

    let deleteId = null;
    window.deleteScholarship = (id) => {
        deleteId = id;
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteScholarshipModal'));
        modal.show();
    };

    const confirmDeleteBtn = document.getElementById('confirmDeleteScholarshipBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', async () => {
            if (!deleteId) return;
            const originalHtml = confirmDeleteBtn.innerHTML;
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';

            const success = await FormService.deleteRecord(`/admin/scholarships/${deleteId}`, () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteScholarshipModal'));
                if (modal) modal.hide();
                tableService.fetchData();
            });

            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.innerHTML = originalHtml;
            if (success) deleteId = null;
        });
    }
});