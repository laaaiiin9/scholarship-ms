@extends('layouts.admin')
@section('header_title', 'Renewal Submissions')
@section('title', 'Admin Renewals')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #4f46e5 0%, #7e22ce 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i data-lucide="refresh-cw" style="width: 32px; height: 32px;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Scholarship Renewals</h4>
                        <p class="mb-0 text-white-50">Review and approve renewal requests from active scholars.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4" id="renewalStats">
        <!-- Rendered by JS or static for now -->
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
                        <option value="SUBMITTED">Submitted</option>
                        <option value="UNDER_REVIEW">Under Review</option>
                        <option value="APPROVED">Approved</option>
                        <option value="REJECTED">Rejected</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted small text-uppercase" style="letter-spacing: 0.5px;">
                        <tr>
                            <th class="ps-4 fw-medium border-bottom-0">Student & Scholarship</th>
                            <th class="fw-medium border-bottom-0">Original Application</th>
                            <th class="fw-medium border-bottom-0">Status</th>
                            <th class="fw-medium border-bottom-0">Date Submitted</th>
                            <th class="pe-4 fw-medium border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0" id="renewals-table-body">
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-transparent border-top p-4" id="pagination-container"></div>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fw-bold">Review Renewal Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <div id="renewalDetails" class="mb-4">
                    <!-- Dynamic details -->
                </div>

                <form id="reviewForm">
                    <div class="mb-4">
                        <label for="statusSelect" class="form-label fw-bold small text-muted text-uppercase">Decision Status</label>
                        <select class="form-select rounded-3 shadow-sm border-eskoylar-primary-subtle" id="statusSelect" name="status" required>
                            <option value="UNDER_REVIEW">Under Review</option>
                            <option value="APPROVED">Approve (Create Disbursement)</option>
                            <option value="REJECTED">Reject (Cancel Pending Disbursement)</option>
                        </select>
                        <div class="form-text small text-muted mt-2">
                             <i data-lucide="info" style="width: 12px;"></i> Approving will automatically queue a financial disbursement. Rejecting will cancel any existing pending records.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label fw-bold small text-uppercase">Internal Remarks</label>
                        <textarea class="form-control rounded-3" id="remarks" name="remarks" rows="3" placeholder="Add any technical notes or reasons for rejection..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-link text-muted px-4 text-decoration-none" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-eskoylar-primary text-white px-5 py-2 rounded-3 shadow-sm" id="saveReviewBtn">Submit Decision</button>
            </div>
        </div>
    </div>
</div>
@endsection
