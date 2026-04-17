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
        <!-- Total Received Funds -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4 shadow-sm border-0 bg-primary text-white overflow-hidden position-relative">
                <div class="position-absolute opacity-10" style="right: -10px; bottom: -10px;">
                    <i data-lucide="banknote" style="width: 80px; height: 80px;"></i>
                </div>
                <div class="position-relative z-index-1">
                    <h3 class="fw-bold mb-1">₱{{ number_format($totalReceived, 2) }}</h3>
                    <p class="text-white-50 fw-medium mb-1 small">Total Funds Received</p>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="col-sm-3 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon bg-info-subtle text-info" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;">
                        <i data-lucide="file-text" style="width: 18px;"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-0">{{ $totalApplications ?? 0 }}</h4>
                <p class="text-muted small mb-0">Applications</p>
            </div>
        </div>

        <!-- Pending / Under Review -->
        <div class="col-sm-3 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon bg-warning-subtle text-warning" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;">
                        <i data-lucide="clock" style="width: 18px;"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-0">{{ $pendingApplications ?? 0 }}</h4>
                <p class="text-muted small mb-0">Pending</p>
            </div>
        </div>

        <!-- Decided / Approved -->
        <div class="col-sm-3 col-xl-3">
            <div class="card stat-card h-100 p-4 rounded-4 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon bg-success-subtle text-success" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;">
                        <i data-lucide="check-circle-2" style="width: 18px;"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-0">{{ $approvedApplications ?? 0 }}</h4>
                <p class="text-muted small mb-0">Approved</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Recent Notifications -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-body">Latest Updates</h5>
                    <a href="{{ route('student.notifications.index') }}" class="btn btn-sm btn-link p-0 text-decoration-none small">View Inbox</a>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush gap-3">
                        @forelse($recentNotifications as $n)
                            <div class="d-flex gap-3 position-relative">
                                @php $color = $n->type === 'ALERT' ? 'danger' : ($n->type === 'ANNOUNCEMENT' ? 'primary' : 'info'); @endphp
                                <div class="avatar-circle sm bg-{{ $color }}-subtle text-{{ $color }}">
                                    <i data-lucide="bell" style="width: 16px;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-xs fw-bold">{{ $n->title }}</h6>
                                    <p class="mb-0 text-muted text-xs text-truncate" style="max-width: 200px;">{{ $n->message }}</p>
                                    <small class="text-muted" style="font-size: 0.65rem;">{{ $n->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted py-4 small">No new notifications.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracker / Progress -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0 text-body">Application Progress</h5>
                </div>
                <div class="card-body p-4">
                    @if($activeApplications->first())
                        @php $latest = $activeApplications->first(); @endphp
                        <div class="p-3 bg-body-tertiary rounded-4 mb-4 border border-dashed">
                            <h6 class="mb-1 fw-bold text-truncate">{{ $latest->scholarship->name }}</h6>
                            <span class="badge bg-primary-subtle text-primary small rounded-pill px-3">Currently: {{ str_replace('_', ' ', $latest->status) }}</span>
                        </div>
                        
                        <div class="position-relative mt-4 px-3">
                            <div class="progress" style="height: 6px;">
                                @php
                                    $progress = 10;
                                    if ($latest->status === 'SUBMITTED') $progress = 40;
                                    if ($latest->status === 'UNDER_REVIEW') $progress = 70;
                                    if ($latest->status === 'DECIDED') $progress = 100;
                                @endphp
                                <div class="progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 small text-muted">
                                <div class="text-center">
                                    <div class="mb-1 fw-bold {{ $progress >= 10 ? 'text-primary' : '' }}">Draft</div>
                                    <div class="text-xs">Initial Prep</div>
                                </div>
                                <div class="text-center">
                                    <div class="mb-1 fw-bold {{ $progress >= 40 ? 'text-primary' : '' }}">Submitted</div>
                                    <div class="text-xs">Verification</div>
                                </div>
                                <div class="text-center">
                                    <div class="mb-1 fw-bold {{ $progress >= 70 ? 'text-primary' : '' }}">Review</div>
                                    <div class="text-xs">Final Audit</div>
                                </div>
                                <div class="text-center">
                                    <div class="mb-1 fw-bold {{ $progress >= 100 ? 'text-primary' : '' }}">Result</div>
                                    <div class="text-xs">Decision</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted small">Submit an application to track your progress here.</p>
                        </div>
                    @endif
                </div>
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
                        <thead class="bg-body-tertiary text-muted small text-uppercase">
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
