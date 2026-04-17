@extends('layouts.admin')
@section('title', 'Applications Report')
@section('header_title', 'Detailed Applications Report')

@section('content')
<div class="container-fluid p-0">
    <!-- Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Applications Data</h4>
            <p class="text-muted small mb-0">Browse, filter, and export detailed application records.</p>
        </div>
        <div>
            <a href="#" id="exportBtn" class="btn btn-outline-success btn-sm px-4 rounded-3 shadow-sm d-flex align-items-center gap-2">
                <i data-lucide="download" style="width: 16px;"></i> Export as CSV
            </a>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-sm fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Search Applicant</label>
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                        <input type="text" id="reportSearch" class="form-control ps-5" placeholder="Name or email...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-sm fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Scholarship Program</label>
                    <select id="scholarshipFilter" class="form-select">
                        <option value="">All Programs</option>
                        @foreach($scholarships as $scholarship)
                            <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-sm fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="SUBMITTED">Submitted</option>
                        <option value="UNDER_REVIEW">Under Review</option>
                        <option value="DECIDED">Decided</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button id="resetFilters" class="btn btn-light border w-100 rounded-3">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <tr>
                            <th class="ps-4 py-3">Applicant</th>
                            <th class="py-3">Scholarship</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Date Applied</th>
                            <th class="py-3">Decision</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="report-table-body">
                        <!-- Loaded via AJAX -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div id="pagination-container" class="p-4 border-top"></div>
        </div>
    </div>
</div>
@endsection
