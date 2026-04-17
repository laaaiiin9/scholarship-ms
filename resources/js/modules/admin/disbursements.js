import * as bootstrap from 'bootstrap';
import { createIcons, icons } from 'lucide';
import TableService from '../../services/admin/table';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Table Service
    const tableService = new TableService({
        tableBodyId: 'disbursements-table-body',
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/disbursements/list',
        renderRow: (item) => {
            const studentName = item.application?.user?.name || 'Unknown Student';
            const scholarshipName = item.application?.scholarship?.name || 'Unknown Scholarship';
            const referenceId = item.renewal_id ? `Renewal #${item.renewal_id}` : `Initial #${item.application_id}`;

            // Status Badges
            let statusBadge = '';
            switch (item.status) {
                case 'PAID':
                    statusBadge = `<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Released</span>`;
                    break;
                case 'CANCELLED':
                    statusBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Cancelled</span>`;
                    break;
                default:
                    statusBadge = `<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Pending</span>`;
            }

            const amountLabel = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(item.amount);
            const payoutDate = item.payout_date ? new Date(item.payout_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : '—';

            return `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle sm bg-success-subtle text-success">
                                <i data-lucide="user" style="width: 16px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold text-body">${studentName}</h6>
                                <p class="mb-0 small text-muted">${scholarshipName}</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="text-xs text-muted fw-bold">${referenceId}</span></td>
                    <td class="fw-bold text-eskoylar-primary">${amountLabel}</td>
                    <td>${statusBadge}</td>
                    <td class="text-muted small">${payoutDate}</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-outline-success btn-icon shadow-sm" title="Process Payment" onclick="window.processPayout(${item.id})">
                            <i data-lucide="credit-card" style="width: 16px;"></i>
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

    // Toggle Payout Date visibility
    const payoutStatus = document.getElementById('payoutStatus');
    const payoutDateContainer = document.getElementById('payoutDateContainer');
    if (payoutStatus && payoutDateContainer) {
        payoutStatus.addEventListener('change', () => {
            if (payoutStatus.value === 'PAID') {
                payoutDateContainer.classList.remove('d-none');
            } else {
                payoutDateContainer.classList.add('d-none');
            }
        });
    }

    // 2. Initialize Form Service
    const formService = new FormService({
        formId: 'payoutForm',
        saveBtnId: 'savePayoutBtn',
        modalId: 'payoutModal',
        buildUrl: (formData) => {
            const id = window.currentDisbursementId;
            return { url: `/admin/disbursements/process/${id}`, isEdit: true };
        },
        onSaved: () => {
            tableService.fetchData();
        }
    });

    // 3. Expose Global Payout Handler
    window.processPayout = async (id) => {
        window.currentDisbursementId = id;
        const summaryContainer = document.getElementById('disbursementSummary');
        summaryContainer.innerHTML = '<span class="spinner-border spinner-border-sm text-primary"></span> Loading...';

        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('payoutModal'));
        modal.show();

        try {
            // We fetch the record via the list endpoint with an ID filter
            const response = await fetch(`/admin/disbursements/list?id=${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const results = await response.json();
            const data = results.data.find(d => d.id == id);

            if (data) {
                document.getElementById('amount').value = data.amount;
                document.getElementById('payoutStatus').value = data.status;
                if (data.status === 'PAID') {
                    payoutDateContainer.classList.remove('d-none');
                    document.getElementById('payout_date').value = data.payout_date || new Date().toISOString().split('T')[0];
                } else {
                    payoutDateContainer.classList.add('d-none');
                }

                summaryContainer.innerHTML = `
                    <div class="row g-2">
                        <div class="col-6"><span class="text-muted">Payee:</span> <span class="fw-bold">${data.application?.user?.profile?.first_name} ${data.application?.user?.profile?.last_name}</span></div>
                        <div class="col-6"><span class="text-muted">Type:</span> <span class="fw-bold">${data.renewal_id ? 'Renewal' : 'Initial Grant'}</span></div>
                        <div class="col-12 text-truncate"><span class="text-muted">Program:</span> <span class="fw-bold">${data.application?.scholarship?.name}</span></div>
                        <div class="col-12">
                            <div class="alert bg-success-subtle border-0 text-success py-2 px-3 rounded-3 mb-0 d-flex align-items-center gap-2">
                                <i data-lucide="info" style="width: 14px;"></i>
                                <span>Max Allowance: <strong>₱${new Intl.NumberFormat('en-PH').format(data.application?.scholarship?.max_amount || 0)}</strong></span>
                            </div>
                        </div>
                    </div>
                `;
                createIcons({ icons });
            }
        } catch (error) {
            console.error('Error fetching disbursement:' + error);
            summaryContainer.innerHTML = '<div class="text-danger">Failed to load details.</div>';
        }
    };
});
