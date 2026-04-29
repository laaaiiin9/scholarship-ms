import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('requirements-table-body');
    const requirementForm = document.getElementById('requirementForm');
    
    if (!tableBody && !requirementForm) return;

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
                            <div class="avatar-circle sm bg-eskoylar-primary bg-opacity-10 text-eskoylar-primary">
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
                    <td>
                        <span class="badge ${item.type === 'RENEWAL' ? 'bg-info-subtle text-info border border-info-subtle' : 'bg-primary-subtle text-primary border border-primary-subtle'} px-3 py-2 rounded-pill">
                            ${item.type}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm btn-outline-eskoylar-primary btn-icon shadow-sm" title="Edit" onclick="window.editRequirement(${item.id})">
                                <i data-lucide="pencil" style="width: 16px;"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-icon shadow-sm" title="Delete" onclick="window.deleteRequirement(${item.id})">
                                <i data-lucide="trash" style="width: 16px;"></i>
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
            document.getElementById('type').value = data.type || 'APPLICATION';
            
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

    const confirmDeleteBtn = document.getElementById('confirmDeleteRequirementBtn');
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
