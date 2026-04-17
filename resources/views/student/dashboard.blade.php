@extends('layouts.student')
@section('header_title', 'Student Dashboard')
@section('title', 'My Dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Welcome back{{ auth()->user() ? ', ' . explode(' ', auth()->user()->name)[0] : '' }}!</h4>
        <p class="text-muted mb-0">Here is an overview of your scholarship applications.</p>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <!-- Total Applications -->
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100 p-4 rounded-4 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-primary-subtle text-eskoylar-primary" style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:12px;">
                        <i data-lucide="file-text"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalApplications ?? 0 }}</h3>
                <p class="text-muted fw-medium mb-1">Total Applications</p>
            </div>
        </div>

        <!-- Pending / Under Review -->
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100 p-4 rounded-4 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-warning-subtle text-warning" style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:12px;">
                        <i data-lucide="clock"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ $pendingApplications ?? 0 }}</h3>
                <p class="text-muted fw-medium mb-1">Pending Review</p>
            </div>
        </div>

        <!-- Decided / Approved -->
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100 p-4 rounded-4 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-success-subtle text-success" style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:12px;">
                        <i data-lucide="check-circle-2"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ $approvedApplications ?? 0 }}</h3>
                <p class="text-muted fw-medium mb-1">Approved</p>
            </div>
        </div>
    </div>
    
    <div class="mb-4">
        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
            <i data-lucide="activity" class="text-eskoylar-primary"></i> Recent Activity
        </h5>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Scholarship</th>
                                <th class="py-3">Applied On</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeApplications as $app)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <h6 class="mb-0 fw-bold text-body">{{ $app->scholarship->name ?? 'Unknown' }}</h6>
                                    </td>
                                    <td class="text-muted py-3">
                                        {{ $app->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="py-3">
                                        @if($app->status === 'DECIDED')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Decision Issued</span>
                                        @elseif($app->status === 'SUBMITTED')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">Submitted</span>
                                        @elseif($app->status === 'UNDER_REVIEW')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Under Review</span>
                                        @elseif($app->status === 'REVISION_REQUIRED')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Revision Required</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">{{ str_replace('_', ' ', $app->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('student.applications.show', $app->id) }}" class="btn btn-sm btn-outline-eskoylar-primary rounded-pill px-3 shadow-none">
                                            Track
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i data-lucide="inbox" style="width:32px;height:32px;" class="mb-2 opacity-50"></i>
                                        <p class="mb-0">You haven't submitted any applications yet.</p>
                                        <a href="{{ route('student.scholarships') }}" class="btn btn-sm btn-eskoylar-primary text-white mt-3 shadow-none px-4 rounded-3">Explore Scholarships</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
