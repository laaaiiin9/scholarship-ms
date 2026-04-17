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

    <!-- Tables Row -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom-0 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0">Recent Candidate Submissions</h5>
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-eskoylar-primary rounded-pill px-3">View All</a>
                    </div>
                </div>
                <div class="card-body p-0 pb-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted" style="font-size: 0.8rem;">
                                <tr>
                                    <th class="ps-4 fw-medium border-bottom-0 pb-3">Applicant Name</th>
                                    <th class="fw-medium border-bottom-0 pb-3">Scholarship</th>
                                    <th class="fw-medium border-bottom-0 pb-3">Status</th>
                                    <th class="fw-medium border-bottom-0 pb-3">Applied</th>
                                    <th class="pe-4 fw-medium border-bottom-0 pb-3 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentApplications as $app)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-circle sm bg-eskoylar-primary bg-opacity-10 text-eskoylar-primary">
                                                    {{ strtoupper(substr($app->user->profile->first_name ?? $app->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-body">{{ ($app->user->profile->first_name ?? '') . ' ' . ($app->user->profile->last_name ?? $app->user->name) }}</h6>
                                                    <small class="text-muted">{{ $app->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-body fw-medium">{{ $app->scholarship->name }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $color = 'secondary';
                                                switch($app->status) {
                                                    case 'SUBMITTED': $color = 'primary'; break;
                                                    case 'UNDER_REVIEW': $color = 'warning'; break;
                                                    case 'DECIDED': $color = 'success'; break;
                                                    case 'REVISION_REQUIRED': $color = 'danger'; break;
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $color }}-subtle text-{{ $color }} border border-{{ $color }}-subtle px-3 py-2 rounded-pill">
                                                {{ str_replace('_', ' ', $app->status) }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $app->created_at->diffForHumans() }}
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-sm btn-icon btn-outline-eskoylar-primary rounded-3 shadow-sm" title="View Submission">
                                                <i data-lucide="eye" style="width: 14px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">No recent applications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection