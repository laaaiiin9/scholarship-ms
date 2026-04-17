@extends('layouts.student')
@section('header_title', 'Application Tracking')
@section('title', 'Track Progress')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4 d-flex align-items-center gap-3">
        <a href="{{ route('student.applications.index') }}" class="btn btn-icon border shadow-sm">
            <i data-lucide="arrow-left" style="width: 20px;"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-1">Track Application</h4>
            <p class="text-muted mb-0">Ref: #{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Progress Column -->
        <div class="col-lg-8">
            <!-- Progress Timeline Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4">
                    <h5 class="fw-bold mb-0">Application Journey</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="position-relative ps-4 border-start border-2 ms-2 mt-2" style="border-color: #e9ecef !important;">
                        
                        <!-- Stage 1: Submitted -->
                        <div class="mb-5 position-relative">
                            <div class="position-absolute translate-middle" style="left: -25px; top: 0;">
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                    <i data-lucide="check" class="text-white" style="width: 12px; height: 12px;"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1">Application Submitted</h6>
                            <p class="text-muted small mb-0">Your application has been received and is waiting for initial screening.</p>
                            <small class="text-eskoylar-primary fw-medium">{{ $application->created_at->format('M d, Y h:i A') }}</small>
                        </div>

                        <!-- Stage 2: Under Review -->
                        @php $isUnderReview = in_array($application->status, ['UNDER_REVIEW', 'DECIDED', 'REVISION_REQUIRED']); @endphp
                        <div class="mb-5 position-relative">
                            <div class="position-absolute translate-middle" style="left: -25px; top: 0;">
                                <div class="rounded-circle {{ $isUnderReview ? 'bg-success' : 'bg-white border border-2' }} d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                    @if($isUnderReview)
                                        <i data-lucide="check" class="text-white" style="width: 12px; height: 12px;"></i>
                                    @endif
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1 {{ $isUnderReview ? '' : 'text-muted' }}">Administrative Review</h6>
                            <p class="text-muted small mb-0">An administrator is currently reviewing your documents and eligibility.</p>
                        </div>

                        <!-- Stage 3: Decision -->
                        @php $isDecided = $application->status === 'DECIDED'; @endphp
                        <div class="position-relative">
                            <div class="position-absolute translate-middle" style="left: -25px; top: 0;">
                                <div class="rounded-circle {{ $isDecided ? 'bg-success' : 'bg-white border border-2' }} d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                    @if($isDecided)
                                        <i data-lucide="check" class="text-white" style="width: 12px; height: 12px;"></i>
                                    @endif
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1 {{ $isDecided ? '' : 'text-muted' }}">Final Decision Issued</h6>
                            <p class="text-muted small mb-0">The screening process is complete and a final result has been issued.</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($application->status === 'DECIDED' && $application->decision)
            <!-- Decision Result Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-{{ $application->decision->result === 'APPROVED' ? 'success' : ($application->decision->result === 'REJECTED' ? 'danger' : 'warning') }}-subtle mb-4">
                <div class="card-body p-4 text-center">
                    <div class="avatar-circle mx-auto mb-3 bg-{{ $application->decision->result === 'APPROVED' ? 'success' : ($application->decision->result === 'REJECTED' ? 'danger' : 'warning') }} text-white">
                        <i data-lucide="{{ $application->decision->result === 'APPROVED' ? 'award' : ($application->decision->result === 'REJECTED' ? 'x-circle' : 'clock-3') }}"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Result: {{ $application->decision->result }}</h4>
                    <p class="text-body mb-0">The evaluation of your application for <strong>{{ $application->scholarship->name }}</strong> is finished.</p>
                </div>
            </div>
            @endif

            @if($application->status === 'REVISION_REQUIRED')
            <div class="card border-0 shadow-sm rounded-4 border-start border-4 border-danger mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-danger"><i data-lucide="alert-triangle"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Action Required: Revision Needed</h6>
                            <p class="text-muted mb-0">The admissions team has requested changes or additional documents for your application. Please check your email or contact support for details.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Details Column -->
        <div class="col-lg-4">
            <!-- Scholarship Snapshot -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i data-lucide="info" style="width: 18px;" class="text-eskoylar-primary"></i> Scholarship Info
                    </h6>
                    <h5 class="fw-bold text-eskoylar-primary mb-2">{{ $application->scholarship->name }}</h5>
                    <p class="text-muted small mb-3">{{ Str::limit($application->scholarship->description, 100) }}</p>
                    <div class="border border-secondary-subtle p-3 rounded-3">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Applied On:</span>
                            <span class="fw-medium">{{ $application->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">Batch/Period:</span>
                            <span class="fw-medium text-end">{{ $application->applicationPeriod->name ?? 'Default Period' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Checklist -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-2">
                    <h6 class="fw-bold mb-0">Verified Documents</h6>
                </div>
                <div class="card-body p-4 pt-2">
                    <ul class="list-group list-group-flush">
                        @foreach($application->documents as $doc)
                        <li class="list-group-item px-0 border-0 d-flex align-items-center justify-content-between py-2">
                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <i data-lucide="file-check" class="text-success flex-shrink-0" style="width: 16px;"></i>
                                <span class="small text-truncate text-muted">{{ $doc->requirement->name ?? 'Document' }}</span>
                            </div>
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-eskoylar-primary small text-decoration-none fw-medium">View</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
