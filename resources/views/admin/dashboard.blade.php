@extends('layouts.admin')
@section('header_title', 'Dashboard')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Overview</h4>
        <p class="text-muted mb-0">Here are your quick insights for this term.</p>
    </div>

    <!-- Financials Row -->
    <div class="row g-4 mb-4">
        <!-- Total Funds Released -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-primary text-white overflow-hidden position-relative">
                <div class="position-absolute opacity-10" style="right: -10px; bottom: -10px;">
                    <i data-lucide="banknote" style="width: 120px; height: 120px;"></i>
                </div>
                <div class="position-relative z-index-1">
                    <p class="text-white-50 fw-medium mb-1">Total Funds Released</p>
                    <h2 class="fw-bold mb-2">₱{{ number_format($totalReleased, 2) }}</h2>
                    <div class="d-flex align-items-center gap-2 small">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-2">Actual Payouts</span>
                        <span class="text-white-50">across all scholarships</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Potential Commitment -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-dark text-white overflow-hidden position-relative">
                <div class="position-absolute opacity-10" style="right: -10px; bottom: -10px;">
                    <i data-lucide="trending-up" style="width: 120px; height: 120px;"></i>
                </div>
                <div class="position-relative z-index-1">
                    <p class="text-white-50 fw-medium mb-1">Calculated Potential</p>
                    <h2 class="fw-bold mb-2">₱{{ number_format($potentialFunds, 2) }}</h2>
                    <div class="d-flex align-items-center gap-2 small">
                        <span class="badge bg-white bg-opacity-10 text-white rounded-pill px-2">Pending Approval</span>
                        <span class="text-white-50">estimated commitment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Application Trends -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-bottom-0 p-4">
                    <h5 class="fw-bold mb-0">Application Trends</h5>
                    <p class="text-muted small mb-0">Monthly submission volume for the last 6 months</p>
                </div>
                <div class="card-body p-4 pt-0">
                    <div style="height: 300px;">
                        <canvas id="trendsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Status Distribution -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-bottom-0 p-4">
                    <h5 class="fw-bold mb-0">Program Popularity</h5>
                    <p class="text-muted small mb-0">Applications per scholarship</p>
                </div>
                <div class="card-body p-4 pt-0 d-flex flex-column justify-content-center">
                    <div style="height: 250px;">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Stats Summary -->
    <div class="row g-4 mb-4">
        <!-- Open Applications -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100 p-4 rounded-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-primary-subtle text-eskoylar-primary">
                        <i data-lucide="inbox"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($totalApplications) }}</h3>
                <p class="text-muted fw-medium mb-1">Open Applications</p>
            </div>
        </div>

        <!-- For Review -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100 p-4 rounded-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i data-lucide="file-search"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($forReviewCount) }}</h3>
                <p class="text-muted fw-medium mb-1">For Review</p>
            </div>
        </div>

        <!-- Approved -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100 p-4 rounded-4">
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
            <div class="card stat-card border-0 shadow-sm h-100 p-4 rounded-4">
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

    <!-- Hidden Data for Analytics -->
    <div id="analytics-data"
        data-months='@json($months)'
        data-trend='@json($trendData)'
        data-distribution='@json($scholarshipStats)'
        class="d-none">
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
    @endsection