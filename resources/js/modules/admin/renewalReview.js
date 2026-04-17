import * as bootstrap from 'bootstrap';
import { createIcons, icons } from 'lucide';
import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Table Service
    const tableService = new TableService({
        tableBodyId: 'renewals-table-body',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/renewal-submissions/list',
        renderRow: (item) => {
            const profile = item.application?.user?.profile;
            const studentName = profile ? `${profile.first_name} ${profile.last_name}` : (item.application?.user?.username || 'Unknown Student');
            const scholarshipName = item.application?.scholarship?.name || 'Unknown Scholarship';
            const applicationUid = `APP-${String(item.application_id).padStart(5, '0')}`;

            // Status Badges
            let statusBadge = '';
            switch (item.status) {
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
                            <div class="avatar-circle sm bg-primary-subtle text-primary border border-primary-subtle">
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
                    <td class="text-muted small">${new Date(item.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</td>
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
            return { url: `/admin/renewal-submissions/status/${id}`, isEdit: true };
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
            const response = await fetch(`/admin/renewal-submissions/view/${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();

            if (response.ok) {
                // Pre-fill form
                const statusSelect = document.getElementById('statusSelect');
                if (statusSelect) statusSelect.value = data.status;
                document.getElementById('remarks').value = data.remarks || '';

                // Render dynamic details
                const detailProfile = data.user?.profile;
                const detailStudentName = detailProfile ? `${detailProfile.first_name} ${detailProfile.last_name}` : (data.user?.username || 'Unknown Student');

                detailsContainer.innerHTML = `
                    <div class="p-3 bg-body-tertiary rounded-4 border border-dashed mb-3">
                        <div class="row g-3">
                            <div class="col-md-6 text-sm">
                                <span class="text-muted d-block small mb-1 text-uppercase fw-bold" style="font-size: 0.65rem;">Student Name</span>
                                <span class="fw-bold text-body">${detailStudentName}</span>
                            </div>
                            <div class="col-md-6 text-sm">
                                <span class="text-muted d-block small mb-1 text-uppercase fw-bold" style="font-size: 0.65rem;">Scholarship</span>
                                <span class="fw-bold text-eskoylar-primary">${data.scholarship?.name}</span>
                            </div>
                            <div class="col-md-4 text-sm">
                                <span class="text-muted d-block small mb-1 text-uppercase fw-bold" style="font-size: 0.65rem;">Current GWA</span>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2">${detailProfile?.gwa || 'N/A'}</span>
                            </div>
                            <div class="col-md-4 text-sm">
                                <span class="text-muted d-block small mb-1 text-uppercase fw-bold" style="font-size: 0.65rem;">Year Level</span>
                                <span class="fw-bold text-body">${detailProfile?.year_level || 'N/A'}</span>
                            </div>
                            <div class="col-md-4 text-sm">
                                <span class="text-muted d-block small mb-1 text-uppercase fw-bold" style="font-size: 0.65rem;">Course</span>
                                <span class="fw-bold text-body">${detailProfile?.course || 'N/A'}</span>
                            </div>
                            <div class="col-12 mt-3 pt-3 border-top border-dashed">
                                <span class="text-muted d-block small mb-2 text-uppercase fw-bold" style="font-size: 0.65rem;">Verified Renewal Documents</span>
                                <div class="d-flex flex-wrap gap-2">
                                    ${data.documents && data.documents.length > 0 ? data.documents.map(doc => `
                                        <a href="/storage/${doc.file_path}" target="_blank" class="btn btn-xs btn-outline-secondary rounded-pill px-3 py-1 shadow-none" style="font-size: 0.7rem;">
                                            <i data-lucide="file" class="me-1" style="width: 10px;"></i> ${doc.requirement?.name || 'Requirement Document'}
                                        </a>
                                    `).join('') : '<span class="text-muted italic">No renewal documents uploaded.</span>'}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                createIcons({ icons });
            } else {
                detailsContainer.innerHTML = '<div class="alert alert-danger">Failed to load renewal details.</div>';
            }
        } catch (error) {
            console.error('Error fetching renewal details:', error);
            detailsContainer.innerHTML = '<div class="alert alert-danger">Network error while fetching details.</div>';
        }
    };
});
