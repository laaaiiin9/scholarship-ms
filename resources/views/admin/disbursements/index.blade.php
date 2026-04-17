@extends('layouts.admin')
@section('header_title', 'Financial Disbursements')
@section('title', 'Admin Disbursements')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i data-lucide="dollar-sign" style="width: 32px; height: 32px;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Financial Management</h4>
                        <p class="mb-0 text-white-50">Monitor and record scholarship fund releases to verified scholars.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-md-6">
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                        <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search by student name...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="PENDING">Pending Payout</option>
                        <option value="PAID">Released / Paid</option>
                        <option value="CANCELLED">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted small text-uppercase" style="letter-spacing: 0.5px;">
                        <tr>
                            <th class="ps-4 fw-medium border-bottom-0">Scholar & Program</th>
                            <th class="fw-medium border-bottom-0">Reference</th>
                            <th class="fw-medium border-bottom-0">Amount</th>
                            <th class="fw-medium border-bottom-0">Status</th>
                            <th class="fw-medium border-bottom-0">Payout Date</th>
                            <th class="pe-4 fw-medium border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0" id="disbursements-table-body">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading payouts...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-transparent border-top p-4" id="pagination-container"></div>
    </div>
</div>

<!-- Payout Modal -->
<div class="modal fade" id="payoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fw-bold">Process Disbursement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <div id="disbursementSummary" class="p-3 bg-light rounded-4 border mb-4 text-sm">
                    <!-- Dynamic summary -->
                </div>

                <form id="payoutForm">
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-bold small text-uppercase">Release Amount (₱)</label>
                        <input type="number" class="form-control form-control-lg fw-bold text-eskoylar-primary" id="amount" name="amount" min="0" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="payoutStatus" class="form-label fw-bold small text-uppercase">Payment Status</label>
                        <select class="form-select" id="payoutStatus" name="status" required>
                            <option value="PENDING">Pending (Scheduled)</option>
                            <option value="PAID">Released (Mark as Paid)</option>
                            <option value="CANCELLED">Cancelled / Revoked</option>
                        </select>
                    </div>

                    <div id="payoutDateContainer" class="mb-3 d-none">
                        <label for="payout_date" class="form-label fw-bold small text-uppercase">Transaction Date</label>
                        <input type="date" class="form-control" id="payout_date" name="payout_date" value="{{ date('Y-m-d') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-link text-muted px-4 text-decoration-none" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-eskoylar-primary text-white px-5 py-2 rounded-3 shadow-sm" id="savePayoutBtn">Update Payout</button>
            </div>
        </div>
    </div>
</div>
@endsection
