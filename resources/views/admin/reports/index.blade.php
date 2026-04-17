@extends('layouts.admin')
@section('title', 'Reports & Analytics')
@section('header_title', 'Reports & Analytics')

@section('content')
<div class="container-fluid p-0">
    <!-- Filters Row -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Analytics Overview</h4>
            <p class="text-muted small mb-0">Visualizing platform performance and application trends.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports.applications') }}" class="btn btn-outline-eskoylar-primary btn-sm px-3 rounded-3 shadow-sm d-flex align-items-center gap-2">
                <i data-lucide="file-text" style="width: 16px;"></i> Detailed Reports
            </a>
            <button class="btn btn-eskoylar-primary btn-sm px-3 rounded-3 shadow-sm text-white d-flex align-items-center gap-2">
                <i data-lucide="download" style="width: 16px;"></i> Download PDF
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar-circle sm bg-primary-subtle text-primary">
                            <i data-lucide="users" style="width: 20px;"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">+12%</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($totalApps) }}</h3>
                    <p class="text-muted small mb-0">Total Applications</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar-circle sm bg-success-subtle text-success">
                            <i data-lucide="dollar-sign" style="width: 20px;"></i>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Total Paid</span>
                    </div>
                    <h3 class="fw-bold mb-1">₱{{ number_format($totalDisbursed, 2) }}</h3>
                    <p class="text-muted small mb-0">Total Funds Disbursed</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar-circle sm bg-warning-subtle text-warning">
                            <i data-lucide="check-circle" style="width: 20px;"></i>
                        </div>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">{{ number_format($approvalRate, 1) }}%</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($approvalRate, 1) }}%</h3>
                    <p class="text-muted small mb-0">Overall Approval Rate</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar-circle sm bg-info-subtle text-info">
                            <i data-lucide="award" style="width: 20px;"></i>
                        </div>
                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">Active</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ \App\Models\Scholarship::count() }}</h3>
                    <p class="text-muted small mb-0">Scholarship Programs</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4">
        <!-- Application Trend -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="card-header bg-transparent border-0 p-0 mb-4 d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold mb-1">Monthly Application Volume</h5>
                        <p class="text-muted small mb-0">Number of submissions over the last 6 months.</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-3 border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Last 6 Months
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Year to Date</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div style="height: 350px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outcome Distribution -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="card-header bg-transparent border-0 p-0 mb-4">
                    <h5 class="fw-bold mb-1">Outcome Distribution</h5>
                    <p class="text-muted small mb-0">Current status of all applications.</p>
                </div>
                <div class="card-body p-0 d-flex flex-column align-items-center justify-content-center">
                    <div style="height: 250px; width: 250px;" class="mb-4">
                        <canvas id="outcomeChart"></canvas>
                    </div>
                    <div class="w-100">
                        @foreach($outcomes as $label => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2 small">
                            <span class="text-muted">
                                <span class="d-inline-block rounded-circle me-2" style="width: 10px; height: 10px; background-color: {{ 
                                    $label == 'Approved' ? '#10b981' : ($label == 'Rejected' ? '#ef4444' : ($label == 'Waitlisted' ? '#f59e0b' : '#3b82f6')) 
                                }}"></span>
                                {{ $label }}
                            </span>
                            <span class="fw-bold text-body">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Prepare Data for JS -->
<script>
    window.ReportData = {
        outcomes: @json($outcomes),
        trends: @json($trendData)
    };
</script>
@endsection
