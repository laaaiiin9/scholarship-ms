import TableService from '../../services/admin/table';
import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Applications Table (index.blade.php)
    const tableBodyId = 'student-applications-table-body';
    if (document.getElementById(tableBodyId)) {
        new TableService({
            tableBodyId: tableBodyId,
            paginationContainerId: 'pagination-container',
            endpoint: '/student/applications',
            renderRow: (item) => {
                const date = new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                
                let statusBadge = '';
                switch(item.status) {
                    case 'DRAFT': statusBadge = '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">Draft</span>'; break;
                    case 'SUBMITTED': statusBadge = '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">Submitted</span>'; break;
                    case 'UNDER_REVIEW': statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Under Review</span>'; break;
                    case 'DECIDED': statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Decision Issued</span>'; break;
                    case 'REVISION_REQUIRED': statusBadge = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Revision Required</span>'; break;
                    default: statusBadge = `<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">${item.status}</span>`;
                }

                return `
                    <tr>
                        <td class="ps-4">
                            <h6 class="mb-0 fw-bold text-body">${item.scholarship?.name || 'N/A'}</h6>
                        </td>
                        <td class="text-muted">${date}</td>
                        <td>${statusBadge}</td>
                        <td class="pe-4 text-end">
                            <a href="/student/applications/show/${item.id}" class="btn btn-sm btn-outline-eskoylar-primary rounded-3 d-inline-flex align-items-center gap-2 px-3 shadow-sm">
                                Track Progress <i data-lucide="arrow-right" style="width: 14px;"></i>
                            </a>
                        </td>
                    </tr>
                `;
            }
        });
    }

    // Initialize icons globally for current and future views
    createIcons({ icons });
});
