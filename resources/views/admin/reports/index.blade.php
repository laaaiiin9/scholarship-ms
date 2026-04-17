@extends('layouts.admin')
@section('header_title', 'System Reports')
@section('title', 'Analytics & Reports')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white bg-opacity-10 rounded-circle p-3">
                    <i data-lucide="bar-chart-3" style="width: 32px; height: 32px;"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Reporting Engine</h4>
                    <p class="mb-0 text-white-50">Generate detailed data summaries and export CSV logs for system auditing.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Applications Report Card -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-header bg-transparent border-bottom-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-circle sm bg-primary-subtle text-eskoylar-primary">
                        <i data-lucide="file-text"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Applications Report</h5>
                        <p class="text-muted small mb-0">Export applicant data and status logs</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.reports.export.applications') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Scholarship Program</label>
                        <select name="scholarship_id" class="form-select rounded-3">
                            <option value="">All Programs</option>
                            @foreach($scholarships as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Application Status</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="">All Statuses</option>
                            <option value="SUBMITTED">Submitted</option>
                            <option value="UNDER_REVIEW">Under Review</option>
                            <option value="DECIDED">Decided / Closed</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Start Date</label>
                            <input type="date" name="start_date" class="form-control rounded-3 text-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">End Date</label>
                            <input type="date" name="end_date" class="form-control rounded-3 text-sm">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-eskoylar-primary w-100 py-3 rounded-3 text-white shadow-sm fw-bold">
                        <i data-lucide="download" class="me-2" style="width: 18px;"></i> Build Application CSV
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Financial Reports Card -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-header bg-transparent border-bottom-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-circle sm bg-success-subtle text-success">
                        <i data-lucide="dollar-sign"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Financial Summaries</h5>
                        <p class="text-muted small mb-0">Payer history and disbursement trends</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.reports.export.disbursements') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Payment Status</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="">All Statuses</option>
                            <option value="PENDING">Pending Payout</option>
                            <option value="PAID">Released / Paid</option>
                            <option value="CANCELLED">Cancelled</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Start Date</label>
                            <input type="date" name="start_date" class="form-control rounded-3 text-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">End Date</label>
                            <input type="date" name="end_date" class="form-control rounded-3 text-sm">
                        </div>
                    </div>
                    <div class="alert bg-success-subtle border-0 text-success rounded-4 d-flex gap-3 mb-4 p-3 shadow-none">
                        <i data-lucide="shield-check" style="width: 24px; min-width: 24px;"></i>
                        <p class="mb-0 small fw-medium">Sensitive Data Protection: Financial exports include payout methods and reference IDs. Restricted personnel only.</p>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-3 rounded-3 text-white shadow-sm fw-bold">
                        <i data-lucide="download-cloud" class="me-2" style="width: 18px;"></i> Build Financial Log
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
