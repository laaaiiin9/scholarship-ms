import { createIcons, icons } from 'lucide';
import { showToast } from '../../utils/toast';
import TableService from '../../services/admin/table';

document.addEventListener('DOMContentLoaded', () => {

    // 1. My Applications Table Initialization
    const tableBodyId = 'student-applications-table-body';
    if (document.getElementById(tableBodyId)) {
        const tableService = new TableService({
            tableBodyId: tableBodyId,
            paginationContainerId: 'pagination-container',
            searchInputId: 'searchInput',
            endpoint: '/student/applications',
            renderRow: (item) => {
                const date = new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                
                let statusBadge = '';
                switch (item.status) {
                    case 'SUBMITTED': statusBadge = '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">Submitted</span>'; break;
                    case 'UNDER_REVIEW': statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Under Review</span>'; break;
                    case 'DECIDED': statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Final Decision</span>'; break;
                    case 'REVISION_REQUIRED': statusBadge = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Revision Needed</span>'; break;
                    default: statusBadge = `<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">${item.status}</span>`;
                }

                return `
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle sm bg-primary-subtle text-eskoylar-primary">
                                    <i data-lucide="file-text" style="width: 18px;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-body">${item.scholarship?.name || 'Unknown Scholarship'}</h6>
                            </div>
                        </td>
                        <td class="text-muted">${date}</td>
                        <td>${statusBadge}</td>
                        <td class="pe-4 text-end">
                            <a href="/student/applications/show/${item.id}" class="btn btn-sm btn-icon btn-outline-eskoylar-primary rounded-3 shadow-sm" title="Track Progress">
                                <i data-lucide="eye" style="width: 16px;"></i>
                            </a>
                        </td>
                    </tr>
                `;
            }
        });

        // Search and Status filtering
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', (e) => {
                tableService.setExtraParams({ status: e.target.value });
            });
        }
    }

    // 2. Application Form Submission (Create Mode)
    const form = document.getElementById('applicationForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const originalHtml = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Uploading...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const formData = new FormData(form);

            try {
                const response = await fetch('/student/applications', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    if (response.status === 401 || response.status === 403) {
                        window.location.href = '/login';
                        return;
                    }
                    let errorMessage = data.message || "Failed to submit.";
                    if (response.status === 422 && data.errors) errorMessage = Object.values(data.errors)[0][0];
                    throw new Error(errorMessage);
                }

                showToast(data.msg || "Successfully submitted!", 'success');
                setTimeout(() => window.location.href = '/student/dashboard', 1500);

            } catch (error) {
                showToast(error.message || "A constraint error occurred.", 'error');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        });
    }

    createIcons({ icons });
});
