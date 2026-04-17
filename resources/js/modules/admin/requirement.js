import * as bootstrap from 'bootstrap';
import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Table Service
    const tableService = new TableService({
        tableBodyId: 'requirements-table-body',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/requirements',
        renderRow: (item) => {
            const scholarshipName = item.scholarship ? item.scholarship.name : 'Unknown Scholarship';
            
            return `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle sm bg-info-subtle text-info">
                                <i data-lucide="file-check" style="width: 18px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold text-body">${item.name}</h6>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">
                        ${scholarshipName}
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm btn-primary btn-icon text-white" title="Edit" onclick="window.editRequirement(${item.id})">
                                <i data-lucide="edit-2" style="width: 16px;"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-icon text-white" title="Delete" onclick="window.deleteRequirement(${item.id})">
                                <i data-lucide="trash-2" style="width: 16px;"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }
    });

    // Handle Extra Filtering (e.g., filter by specific scholarship)
    const scholarshipFilter = document.getElementById('scholarshipFilter');
    if (scholarshipFilter) {
        scholarshipFilter.addEventListener('change', (e) => {
            tableService.setExtraParams({ scholarship_id: e.target.value });
        });
    }

    // 2. Initialize Form Service
    const formService = new FormService({
        formId: 'requirementForm',
        saveBtnId: 'saveRequirementBtn',
        modalId: 'requirementModal',
        buildUrl: (formData) => {
            const id = formData.get('id');
            if (id) {
                return { url: `/admin/requirements/${id}`, isEdit: true };
            }
            return { url: '/admin/requirements/store', isEdit: false };
        },
        onSaved: () => {
            tableService.fetchData();
        }
    });

    // Reset Modal Form upon closing
    const requirementModalEl = document.getElementById('requirementModal');
    if (requirementModalEl) {
        requirementModalEl.addEventListener('hidden.bs.modal', () => {
            document.getElementById('requirementForm').reset();
            document.getElementById('requirement_id').value = '';
            document.getElementById('requirementModalLabel').innerText = 'New Requirement';
        });
    }

    // 3. Expose Global Edit & Delete Handlers
    window.editRequirement = async (id) => {
        const data = await FormService.fetchForEdit(`/admin/requirements/${id}/edit`);
        if (data) {
            document.getElementById('requirement_id').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('scholarship_id').value = data.scholarship_id;
            
            document.getElementById('requirementModalLabel').innerText = 'Edit Requirement';
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('requirementModal'));
            modal.show();
        }
    };

    let deleteId = null;
    window.deleteRequirement = (id) => {
        deleteId = id;
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteRequirementModal'));
        modal.show();
    };

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', async () => {
            if (!deleteId) return;
            const originalHtml = confirmDeleteBtn.innerHTML;
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';

            const success = await FormService.deleteRecord(`/admin/requirements/${deleteId}`, () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteRequirementModal'));
                if (modal) modal.hide();
                tableService.fetchData();
            });

            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.innerHTML = originalHtml;
            if (success) deleteId = null;
        });
    }
});
