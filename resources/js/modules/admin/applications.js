import TableService from '../../services/admin/table';
import { showToast } from '../../utils/toast';
import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    // ---------------------------------------------------------
    // 1. Applications Master Data Table (index.blade.php)
    // ---------------------------------------------------------
    const tableBodyId = 'applications-table-body';
    if (document.getElementById(tableBodyId)) {
        const tableService = new TableService({
            tableBodyId: tableBodyId,
            paginationContainerId: 'pagination-container',
            searchInputId: 'searchInput',
            endpoint: '/admin/applications', // Base route
            renderRow: (item) => {
                const date = new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                let statusBadge = '';
                switch (item.status) {
                    case 'SUBMITTED': statusBadge = '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">Submitted</span>'; break;
                    case 'UNDER_REVIEW': statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Under Review</span>'; break;
                    case 'DECIDED': statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Decided</span>'; break;
                    case 'REVISION_REQUIRED': statusBadge = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Revision Needed</span>'; break;
                    default: statusBadge = `<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">${item.status}</span>`;
                }

                const fullName = item.user?.profile 
                    ? `${item.user.profile.first_name} ${item.user.profile.last_name}`
                    : (item.user?.name || 'Unknown');
                
                const initials = fullName.charAt(0).toUpperCase();

                const courseSchool = item.user?.profile && (item.user.profile.course || item.user.profile.school)
                    ? `<small class="text-muted d-block mt-1">${item.user.profile.course || 'N/A'} • ${item.user.profile.school || 'N/A'}</small>`
                    : '';

                return `
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle sm bg-secondary-subtle text-secondary fw-bold">${initials}</div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-body">${fullName}</h6>
                                    <small class="text-muted">${item.user?.email || ''}</small>
                                    ${courseSchool}
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-body fw-medium">${item.scholarship?.name}</span>
                        </td>
                        <td class="text-muted">${date}</td>
                        <td>${statusBadge}</td>
                        <td class="pe-4 text-end">
                            <a href="/admin/applications/${item.id}" class="btn btn-sm btn-icon btn-outline-eskoylar-primary rounded-3 shadow-sm" title="View Submission">
                                <i data-lucide="eye" style="width: 16px;"></i>
                            </a>
                        </td>
                    </tr>
                `;
            }
        });

        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', (e) => {
                tableService.extraParams.status = e.target.value;
                tableService.currentPage = 1;
                tableService.fetchData();
            });
        }

        const scholarshipFilter = document.getElementById('scholarshipFilter');
        if (scholarshipFilter) {
            scholarshipFilter.addEventListener('change', (e) => {
                tableService.extraParams.scholarship_id = e.target.value;
                tableService.currentPage = 1;
                tableService.fetchData();
            });
        }
    }

    // ---------------------------------------------------------
    // 2. Application Review Console (show.blade.php)
    // ---------------------------------------------------------
    const decisionForm = document.getElementById('decisionForm');
    if (decisionForm) {
        const statusSelect = document.getElementById('statusSelect');
        const resultBox = document.getElementById('decisionResultBox');

        statusSelect.addEventListener('change', (e) => {
            if (e.target.value === 'DECIDED') {
                resultBox.style.display = 'block';
            } else {
                resultBox.style.display = 'none';
            }
        });

        decisionForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const btn = document.getElementById('submitBtn');
            const appId = document.getElementById('app_id').value;
            const status = statusSelect.value;
            const result = document.getElementById('resultSelect').value;
            const remarks = document.getElementById('remarksInput').value;

            if (status === 'DECIDED' && !result) {
                showToast('Please select a final decision result (Approved/Waitlisted/Rejected).', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch(`/admin/applications/${appId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ status, result, remarks })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    let err = data.message || 'An error occurred';
                    if (data.errors) err = Object.values(data.errors)[0][0];
                    showToast(err, 'error');
                    btn.disabled = false;
                    btn.innerHTML = '<i data-lucide="save" style="width: 18px;"></i> Update Application State';
                    createIcons({ icons });
                }
            } catch (error) {
                showToast('Network error processing decision.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i data-lucide="save" style="width: 18px;"></i> Update Application State';
                createIcons({ icons });
            }
        });
    }

    createIcons({ icons });
});
