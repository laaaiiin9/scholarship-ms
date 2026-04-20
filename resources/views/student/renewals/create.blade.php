@extends('layouts.student')
@section('title', 'Submit Renewal')
@section('header_title', 'Application for Renewal')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-eskoylar-primary p-4 border-0">
                    <div class="d-flex align-items-center gap-3 text-white">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2">
                            <i data-lucide="award" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">{{ $scholarship->name }}</h5>
                            <p class="mb-0 small opacity-75">Scholarship Renewal for Current Academic Term</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form id="renewalForm" enctype="multipart/form-data" data-store-url="{{ route('student.renewals.store') }}">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ $application->id }}">
                        <input type="hidden" name="renewal_period_id" value="{{ $activeRenewalPeriod->id }}">

                        <div class="mb-5">
                            <h6 class="fw-bold text-uppercase text-muted small mb-4" style="letter-spacing: 1px;">Scholarship Details</h6>
                            <div class="bg-body-tertiary p-4 rounded-4 border">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="text-muted small d-block mb-1">Scholarship Program</label>
                                        <p class="fw-bold mb-0 text-body">{{ $scholarship->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small d-block mb-1">Original Application ID</label>
                                        <p class="fw-bold mb-0 text-body">#APP-{{ str_pad($application->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small d-block mb-1">Renewal Phase</label>
                                        <p class="fw-bold mb-0 text-body">{{ $activeRenewalPeriod->start_date->format('M Y') }} Payout Cycle</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small d-block mb-1">Student UID</label>
                                        <p class="fw-bold mb-0 text-body">{{ auth()->user()->username }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3" style="letter-spacing: 1px;">Renewal Statement</h6>
                            <div class="form-check p-3 border rounded-4 bg-body-tertiary mb-3">
                                <input class="form-check-input ms-0 me-3" type="checkbox" id="declaration1" required style="width: 20px; height: 20px;">
                                <label class="form-check-label small text-body" for="declaration1">
                                    I hereby declare that I am still currently enrolled and maintaining the required academic standing for this scholarship.
                                </label>
                            </div>
                            <div class="form-check p-3 border rounded-4 bg-body-tertiary">
                                <input class="form-check-input ms-0 me-3" type="checkbox" id="declaration2" required style="width: 20px; height: 20px;">
                                <label class="form-check-label small text-body" for="declaration2">
                                    I understand that my renewal is subject to verification of my grades and enrollment status by the scholarship committee.
                                </label>
                            </div>
                        </div>

                        <!-- Renewal Requirements Section -->
                        <div class="mb-5">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3" style="letter-spacing: 1px;">Renewal Requirements</h6>
                            
                            @php
                                $renewalReqs = $scholarship->requirements->where('type', 'RENEWAL');
                            @endphp

                            @if($renewalReqs->count() > 0)
                                <div class="row g-3">
                                    @foreach($renewalReqs as $index => $req)
                                        <div class="col-12">
                                            <div class="requirement-box p-3 rounded-4 border bg-body-tertiary">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 mb-2 mb-md-0">
                                                        <label class="fw-bold mb-1 d-block">{{ $req->name }}</label>
                                                        <small class="text-muted d-block" style="font-size: 0.7rem;">Please upload proof for renewal (PDF/Image).</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="file" 
                                                               class="form-control form-control-sm rounded-3" 
                                                               name="requirements[{{ $req->id }}]" 
                                                               id="req_{{ $req->id }}" 
                                                               accept=".pdf,.jpg,.jpeg,.png"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-4 rounded-4 border border-dashed text-center bg-body-tertiary">
                                    <i data-lucide="info" class="text-muted mb-2" style="width: 20px;"></i>
                                    <p class="text-muted small mb-0">No specific documents are required for this scholarship's renewal phase.</p>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                            <a href="{{ route('student.renewals.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">Cancel</a>
                            <button type="submit" id="submitRenewalBtn" class="btn btn-eskoylar-primary text-white px-5 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                                <i data-lucide="check-circle" style="width: 18px;"></i>
                                Confirm Renewal Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info border-info-subtle rounded-4 d-flex align-items-start gap-3 p-4">
                <i data-lucide="info" class="text-info" style="width: 24px; flex-shrink: 0;"></i>
                <div class="small">
                    <p class="mb-1 fw-bold">What happens next?</p>
                    <p class="mb-0 text-muted">After submission, administrators will review your current eligibility. Once approved, your scholarship payout for the next term will be processed and scheduled for disbursement.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
