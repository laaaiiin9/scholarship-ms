@extends('layouts.admin')
@section('header_title', 'Dashboard')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Overview</h4>
        <p class="text-muted mb-0">Here are your quick insights for this term.</p>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Open Applications -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-primary-subtle text-eskoylar-primary">
                        <i data-lucide="inbox"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($totalApplications) }}</h3>
                <p class="text-muted fw-medium mb-1">Open Applications</p>
                <small class="text-muted d-block mt-2">
                    <span class="text-eskoylar-primary fw-medium"><i data-lucide="trending-up" style="width: 14px; height: 14px;" class="me-1"></i></span>
                    submitted this term
                </small>
            </div>
        </div>

        <!-- For Review -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i data-lucide="file-search"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($forReviewCount) }}</h3>
                <p class="text-muted fw-medium mb-1">For Review</p>
                <small class="text-muted d-block mt-2">
                    <span class="text-warning fw-medium"><i data-lucide="clock" style="width: 14px; height: 14px;" class="me-1"></i></span>
                    ready for validation
                </small>
            </div>
        </div>

        <!-- Approved -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i data-lucide="check-circle-2"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($approvedCount) }}</h3>
                <p class="text-muted fw-medium mb-1">Approved</p>
            </div>
        </div>

        <!-- Rejected -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i data-lucide="x-circle"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($rejectedCount) }}</h3>
                <p class="text-muted fw-medium mb-1">Rejected</p>
            </div>
        </div>
    </div>
</div>
@endsection