@extends('layouts.student')
@section('header_title', 'My Applications')
@section('title', 'My Applications')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">My Scholarship Applications</h4>
        <p class="text-muted mb-0">Track the status and progress of your submitted scholarship requests.</p>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <!-- Search & Filter Header -->
        <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-md-6 col-lg-5">
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                        <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search applications...">
                    </div>
                </div>
                <div class="col-md-auto d-flex gap-2">
                    <select class="form-select text-muted" id="statusFilter" style="min-width: 180px;">
                        <option value="">All Statuses</option>
                        <option value="SUBMITTED">Submitted</option>
                        <option value="UNDER_REVIEW">Under Review</option>
                        <option value="DECIDED">Final Decision</option>
                        <option value="REVISION_REQUIRED">Revision Needed</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted" style="font-size: 0.8rem;">
                        <tr>
                            <th class="ps-4 fw-medium border-bottom-0 py-3">Scholarship Program</th>
                            <th class="fw-medium border-bottom-0 py-3">Applied On</th>
                            <th class="fw-medium border-bottom-0 py-3">Current Status</th>
                            <th class="pe-4 fw-medium border-bottom-0 py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0" id="student-applications-table-body">
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading applications...
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

@endsection
