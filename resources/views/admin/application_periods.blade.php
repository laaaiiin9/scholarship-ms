@extends('layouts.admin')
@section('header_title', 'Application Periods')
@section('title', 'Admin Application Periods')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Application Periods</h4>
            <p class="text-muted mb-0">Schedule and manage enrollment phases for your scholarships.</p>
        </div>
        <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#periodModal" id="btnNewPeriod">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            New Period
        </button>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <!-- Search -->
        <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-md-6 col-lg-5">
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                        <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search by scholarship or status...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted" style="font-size: 0.8rem;">
                        <tr>
                            <th class="ps-4 fw-medium border-bottom-0">Scholarship Name</th>
                            <th class="fw-medium border-bottom-0">Start Date</th>
                            <th class="fw-medium border-bottom-0">End Date</th>
                            <th class="fw-medium border-bottom-0">Status</th>
                            <th class="pe-4 fw-medium border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0" id="application-periods-table-body">
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-transparent border-top p-4" id="pagination-container">
            <!-- Rendered by JS -->
        </div>
    </div>
</div>

<!-- Form Modal -->
<div class="modal fade" id="periodModal" tabindex="-1" aria-labelledby="periodModalLabel" aria-hidden="true" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom border-dark-subtle">
                <h5 class="modal-title" id="periodModalLabel">New Application Period</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="periodForm">
                    <input type="hidden" id="period_id" name="id">
                    
                    <div class="mb-3">
                        <label for="scholarship_id" class="form-label text-sm fw-medium">Scholarship Program</label>
                        <select class="form-select" id="scholarship_id" name="scholarship_id" required>
                            <option value="">-- Choose Scholarship --</option>
                            @foreach($scholarships as $scholarship)
                                <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a scholarship.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label text-sm fw-medium">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label text-sm fw-medium">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label text-sm fw-medium">Phase Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="DRAFT">DRAFT</option>
                            <option value="OPEN">OPEN</option>
                            <option value="CLOSED">CLOSED</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer border-top border-dark-subtle">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePeriodBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deletePeriodModal" tabindex="-1" aria-labelledby="deletePeriodModalLabel" aria-hidden="true" data-bs-theme="dark">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <div class="text-danger mb-3 d-flex justify-content-center">
                    <i data-lucide="alert-triangle" style="width: 48px; height: 48px;"></i>
                </div>
                <h5 class="mb-2">Delete Period?</h5>
                <p class="text-muted text-sm mb-4">You are about to delete this enrollment period. This action cannot be undone.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
