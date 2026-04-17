import { createIcons, icons } from 'lucide';
import { showToast } from '../../utils/toast';
import GridDataService from '../../services/student/gridData';

document.addEventListener('DOMContentLoaded', () => {
    
    // Only bind if grid container exists
    if (!document.getElementById('scholarships-grid')) return;

    const gridService = new GridDataService({
        containerId: 'scholarships-grid',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/student/scholarships',
        renderCard: (item) => {
            const maxAmount = item.max_amount ? parseFloat(item.max_amount) : 0;
            const amountFormatted = `$${maxAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            
            // Determine active period
            const activePeriod = item.application_periods && item.application_periods.length > 0 ? item.application_periods[0] : null;
            
            let formattedPeriod = '<span class="text-danger">Awaiting Scheduling</span>';
            if (activePeriod) {
                const options = { month: 'short', day: 'numeric', year: 'numeric' };
                const start = new Date(activePeriod.start_date).toLocaleDateString('en-US', options);
                const end = new Date(activePeriod.end_date).toLocaleDateString('en-US', options);
                formattedPeriod = `${start} - ${end}`;
            }

            // Requirements Badges
            let reqsHtml = '';
            if (item.requirements && item.requirements.length > 0) {
                item.requirements.forEach(req => {
                    reqsHtml += `<span class="badge bg-dark-subtle text-body border border-dark rounded-pill me-1 mb-1 fw-normal">${req.name}</span>`;
                });
            } else {
                reqsHtml = `<span class="text-muted" style="font-size:0.85rem;">None specified</span>`;
            }

            // Status / Apply Button logic
            let actionBtnHtml = '';
            
            if (item.has_applied) {
                actionBtnHtml = `<button class="btn btn-secondary w-100 fw-medium" disabled><i data-lucide="check" class="me-2" style="width: 16px;"></i>Applied via Application</button>`;
            } else if (item.has_open_period) {
                // Change from AJAX onclick to normal link
                actionBtnHtml = `<a href="/student/applications/create/${item.id}" class="btn btn-eskoylar-primary w-100 fw-medium shadow-sm transition-all text-white hover-lift">Apply Now</a>`;
            } else {
                actionBtnHtml = `<button class="btn btn-outline-secondary w-100 fw-medium" disabled>Closed / No Active Period</button>`;
            }

            return `
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border border-secondary-subtle rounded-4 transition-all">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-circle sm bg-primary text-white me-3 shadow-sm">
                                    <i data-lucide="graduation-cap" style="width:18px;height:18px;"></i>
                                </div>
                                <h5 class="fw-bold mb-0 text-truncate text-body" title="${item.name}">${item.name}</h5>
                            </div>
                            
                            <h3 class="text-eskoylar-primary fw-bold mb-3">${amountFormatted}</h3>
                            
                            <p class="text-muted flex-grow-1 mb-4" style="font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                ${item.description || 'No description provided.'}
                            </p>
                            
                            <div class="mb-3">
                                <div class="text-body text-uppercase fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Requirements</div>
                                <div class="d-flex flex-wrap">${reqsHtml}</div>
                            </div>
                            
                            <div class="mb-4 bg-dark-subtle rounded p-3">
                                <div class="text-body text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Application Period</div>
                                <div class="d-flex align-items-center gap-2 text-sm pt-1">
                                    <i data-lucide="calendar" style="width: 14px;" class="text-eskoylar-primary"></i>
                                    <span class="text-body fw-medium">${formattedPeriod}</span>
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-2 border-top border-secondary-subtle pt-3">
                                ${actionBtnHtml}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    });

    // Removed window.applyForScholarship as this has been migrated to a dedicated page
});
