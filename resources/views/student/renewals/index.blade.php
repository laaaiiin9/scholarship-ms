@extends('layouts.student')
@section('title', 'Scholarship Renewals')
@section('header_title', 'Renew Your Scholarships')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-circle bg-eskoylar-primary text-white">
                        <i data-lucide="refresh-cw"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Scholarship Renewal</h4>
                        <p class="text-muted mb-0">Continue your academic journey. Renew your existing grants below.</p>
                    </div>
                </div>
            </div>
        </div>

        @if($eligibleApplications->isEmpty())
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="bg-body-secondary rounded-circle p-4" style="width: 100px; height: 100px;">
                            <i data-lucide="info" class="text-muted" style="width: 48px; height: 48px;"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold">No Active Renewals Available</h5>
                    <p class="text-muted mx-auto mb-0" style="max-width: 400px;">You don't have any scholarships eligible for renewal at this moment. This could be because your previous application wasn't approved or no renewal periods are currently open.</p>
                </div>
            </div>
        @else
            @foreach($eligibleApplications as $app)
                @php $period = $app->scholarship->renewalPeriods->first(); @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="badge bg-purple-subtle text-purple mb-3 px-3 py-2 rounded-pill" style="background-color: #f3e8ff; color: #7e22ce;">
                                <i data-lucide="refresh-cw" class="me-1" style="width: 14px;"></i> Eligible for Renewal
                            </div>
                            <h5 class="fw-bold mb-2">{{ $app->scholarship->name }}</h5>
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <span class="text-muted text-sm">Original ID:</span>
                                <span class="badge bg-light text-dark fw-medium border">#APP-{{ str_pad($app->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            
                            <div class="p-3 bg-body-tertiary rounded-3 mb-4">
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Renewal Window:</span>
                                    <span class="fw-medium text-body">{{ $period->start_date->format('M d') }} - {{ $period->end_date->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Provider:</span>
                                    <span class="fw-medium text-body">Eskoylar Office</span>
                                </div>
                            </div>

                            <a href="{{ route('student.renewals.create', $app->id) }}" class="btn btn-eskoylar-primary text-white w-100 py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i data-lucide="file-signature" style="width: 18px;"></i> Renew Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
