@extends('layouts.student')
@section('title', 'Available Scholarships')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Available Scholarships</h4>
        <p class="text-muted mb-0">Browse and apply for active scholarship programs.</p>
    </div>

    <!-- Search & Filters -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-md-6 col-lg-5">
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                        <input type="text" id="searchInput" class="form-control ps-5 rounded-pill" placeholder="Search scholarships by name or description...">
                    </div>
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-outline-secondary rounded-pill d-flex align-items-center gap-2">
                        <i data-lucide="filter" style="width: 16px;"></i>
                        Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Container -->
    <div class="row g-4" id="scholarships-grid">
        <!-- Rendered by JS -->
        <div class="col-12 text-center py-5 text-muted">
            <span class="spinner-border text-eskoylar-primary me-2" role="status" aria-hidden="true"></span>
            <h5 class="mt-3">Loading scholarships...</h5>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4" id="pagination-container">
        <!-- Rendered by JS -->
    </div>
</div>
@endsection
