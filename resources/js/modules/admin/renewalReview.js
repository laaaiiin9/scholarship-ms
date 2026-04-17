import * as bootstrap from 'bootstrap';
import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Table Service
    const tableService = new TableService({
        tableBodyId: 'renewals-table-body',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/renewals',
        renderRow: (item) => {
            const studentName = item.user?.name || 'Unknown Student';
            const scholarshipName = item.scholarship?.name || 'Unknown Scholarship';
            const applicationUid = `APP-${String(item.application_id).padStart(5, '0')}`;
            
            // Status Badges
            let statusBadge = '';
            switch(item.status) {
                case 'APPROVED':
                    statusBadge = `<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Approved</span>`;
                    break;
                case 'REJECTED':
                    statusBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Rejected</span>`;
                    break;
                case 'UNDER_REVIEW':
                    statusBadge = `<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Under Review</span>`;
                    break;
                default:
                    statusBadge = `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">Submitted</span>`;
            }

            return `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle sm bg-light text-primary">
                                ${studentName.charAt(0)}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold text-body">${studentName}</h6>
                                <p class="mb-0 small text-muted">${scholarshipName}</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="text-xs text-muted fw-bold">#${applicationUid}</span></td>
                    <td>${statusBadge}</td>
                    <td class="text-muted small">${new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-eskoylar-primary text-white rounded-3 px-3 shadow-sm" onclick="window.reviewRenewal(${item.id})">
                             Review Submission
                        </button>
                    </td>
                </tr>
            `;
        }
    });

    // Handle Filters
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', () => {
            tableService.fetchData({ status: statusFilter.value });
        });
    }

    // 2. Initialize Form Service
    const formService = new FormService({
        formId: 'reviewForm',
        saveBtnId: 'saveReviewBtn',
        modalId: 'reviewModal',
        buildUrl: (formData) => {
            const id = window.currentRenewalId;
            return { url: `/admin/renewals/${id}/status`, isEdit: true };
        },
        onSaved: () => {
            tableService.fetchData();
        }
    });

    // 3. Expose Global Review Handler
    window.reviewRenewal = async (id) => {
        window.currentRenewalId = id;
        const detailsContainer = document.getElementById('renewalDetails');
        detailsContainer.innerHTML = '<div class="text-center py-4"><span class="spinner-border spinner-border-sm text-primary"></span> Loading details...</div>';
        
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('reviewModal'));
        modal.show();

        try {
            const response = await fetch(`/admin/renewals/${id}`);
            const data = await response.json();
            
            if (response.ok) {
                // Pre-fill form
                const radio = document.querySelector(`input[name="status"][value="${data.status}"]`);
                if (radio) radio.checked = true;
                document.getElementById('remarks').value = data.remarks || '';

                // Render dynamic details
                detailsContainer.innerHTML = `
                    <div class="p-3 bg-light rounded-4 border mb-2">
                        <div class="row g-3">
                            <div class="col-md-6 text-sm">
                                <span class="text-muted d-block">Student Name</span>
                                <span class="fw-bold text-body">${data.user?.name}</span>
                            </div>
                            <div class="col-md-6 text-sm">
                                <span class="text-muted d-block">Scholarship</span>
                                <span class="fw-bold text-body">${data.scholarship?.name}</span>
                            </div>
                            <div class="col-md-6 text-sm">
                                <span class="text-muted d-block">Date of Submission</span>
                                <span class="fw-bold text-body">${new Date(data.created_at).toLocaleString()}</span>
                            </div>
                            <div class="col-md-6 text-sm">
                                <span class="text-muted d-block">Decision Criteria</span>
                                <span class="fw-bold text-body">${data.application?.decision?.result || 'N/A'} (Initial Approval)</span>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                detailsContainer.innerHTML = '<div class="alert alert-danger">Failed to load renewal details.</div>';
            }
        } catch (error) {
            console.error('Error fetching renewal details:', error);
            detailsContainer.innerHTML = '<div class="alert alert-danger">Network error while fetching details.</div>';
        }
    };
});
