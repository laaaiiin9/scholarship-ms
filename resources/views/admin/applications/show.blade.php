@extends('layouts.admin')
@section('header_title', 'Application Details')
@section('title', 'Application Review')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4 d-flex align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.applications.index') }}" class="btn btn-icon border shadow-sm">
                <i data-lucide="arrow-left" style="width: 20px;"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-1">Application File</h4>
                <p class="text-muted mb-0">Ref: #{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
        <div>
            @php
                $statusColor = 'secondary';
                switch($application->status) {
                    case 'SUBMITTED': $statusColor = 'primary'; break;
                    case 'UNDER_REVIEW': $statusColor = 'warning'; break;
                    case 'DECIDED': $statusColor = 'success'; break;
                    case 'REVISION_REQUIRED': $statusColor = 'danger'; break;
                }
            @endphp
            <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} border border-{{ $statusColor }}-subtle px-3 py-2 fs-6">
                {{ str_replace('_', ' ', $application->status) }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Application Info -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4">
                    <h5 class="fw-bold mb-0">Applicant Profile</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-medium">Full Name</div>
                        <div class="col-sm-8 fw-semibold">
                            @if($application->user->profile)
                                {{ $application->user->profile->first_name }} {{ $application->user->profile->last_name }}
                            @else
                                {{ $application->user->name }}
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-medium">Email Address</div>
                        <div class="col-sm-8">{{ $application->user->email }}</div>
                    </div>
                    @if($application->user->profile)
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-medium">School</div>
                        <div class="col-sm-8">{{ $application->user->profile->school ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-medium">Course</div>
                        <div class="col-sm-8">{{ $application->user->profile->course ?? 'N/A' }}</div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-medium">Scholarship Program</div>
                        <div class="col-sm-8 text-eskoylar-primary fw-semibold">{{ $application->scholarship->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-muted fw-medium">Submission Date</div>
                        <div class="col-sm-8">{{ $application->created_at->format('F d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Uploaded Documents -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom-0 p-4">
                    <h5 class="fw-bold mb-0">Attached Requirements</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-bottom-4">
                        @forelse($application->documents as $doc)
                            <div class="list-group-item p-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle sm bg-eskoylar-primary bg-opacity-10 text-eskoylar-primary">
                                        <i data-lucide="file-text" style="width: 16px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-medium">{{ $doc->requirement->name ?? 'Document' }}</h6>
                                        <small class="text-muted">Uploaded {{ $doc->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-eskoylar-primary text-white d-inline-flex gap-2 align-items-center rounded-3">
                                        <i data-lucide="external-link" style="width: 14px;"></i> View File
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center text-muted">
                                <i data-lucide="folder-open" class="mb-3" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                                <p>No documents uploaded for this application.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-2">
                    <h5 class="fw-bold mb-0">Executive Actions</h5>
                </div>
                <div class="card-body p-4 pt-2">
                    <p class="text-muted small mb-4">Trigger system workflows. Ensure all documents are verified before making a final decision.</p>

                    <form id="decisionForm">
                        <input type="hidden" id="app_id" value="{{ $application->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label text-sm fw-medium">Stage Progression</label>
                            <select class="form-select mb-3" id="statusSelect" name="status">
                                <option value="SUBMITTED" {{ $application->status === 'SUBMITTED' ? 'selected' : '' }}>Submitted (Pending)</option>
                                <option value="UNDER_REVIEW" {{ $application->status === 'UNDER_REVIEW' ? 'selected' : '' }}>Mark as Under Review</option>
                                <option value="REVISION_REQUIRED" {{ $application->status === 'REVISION_REQUIRED' ? 'selected' : '' }}>Request Revisions</option>
                                <option value="DECIDED" {{ $application->status === 'DECIDED' ? 'selected' : '' }}>Lock & Issue Decision</option>
                            </select>
                        </div>

                        <!-- Only shows if DECIDED is selected -->
                        <div class="mb-3" id="decisionResultBox" style="display: {{ $application->status === 'DECIDED' ? 'block' : 'none' }}">
                            <label class="form-label text-sm fw-medium">Final Decision Result</label>
                            <select class="form-select" id="resultSelect" name="result">
                                @php $currentResult = $application->decision?->result; @endphp
                                <option value="" disabled {{ !$currentResult ? 'selected' : '' }}>Select output...</option>
                                <option value="APPROVED" {{ $currentResult === 'APPROVED' ? 'selected' : '' }}>Approve Application</option>
                                <option value="WAITLISTED" {{ $currentResult === 'WAITLISTED' ? 'selected' : '' }}>Place on Waitlist</option>
                                <option value="REJECTED" {{ $currentResult === 'REJECTED' ? 'selected' : '' }}>Reject Application</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-sm fw-medium">Remarks (Optional)</label>
                            <textarea class="form-control" rows="3" id="remarksInput" placeholder="Internal notes or comments for the student..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-medium d-flex align-items-center justify-content-center gap-2" id="submitBtn">
                            <i data-lucide="save" style="width: 18px;"></i> Update Application State
                        </button>
                    </form>
                </div>
            </div>

            @if($application->decision)
            <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-body-tertiary">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i data-lucide="scale" style="width: 18px;" class="text-eskoylar-primary"></i> Decision Log
                    </h6>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><span class="text-muted">Issued By:</span> <span class="fw-medium">{{ $application->decision->decider->name ?? 'System' }}</span></li>
                        <li class="mb-2"><span class="text-muted">Result:</span> <span class="fw-bold text-{{ $application->decision->result === 'APPROVED' ? 'success' : ($application->decision->result === 'REJECTED' ? 'danger' : 'warning') }}">{{ $application->decision->result }}</span></li>
                        <li><span class="text-muted">Timestamp:</span> {{ $application->decision->created_at->format('M d, Y H:i') }}</li>
                    </ul>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-2">
                    <h6 class="fw-bold mb-0">Internal Review Log</h6>
                </div>
                <div class="card-body p-4 pt-0">
                    @forelse($application->reviews->sortByDesc('created_at') as $review)
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom border-light-subtle' : '' }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold small">{{ $review->reviewer->name ?? 'Unknown Admin' }}</span>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y H:i') }}</small>
                            </div>
                            <p class="mb-0 small text-body-secondary">{{ $review->remarks }}</p>
                        </div>
                    @empty
                        <p class="text-center text-muted small py-3 mb-0">No internal remarks captured yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
