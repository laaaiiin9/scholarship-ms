@extends('layouts.student')
@section('title', 'Apply for ' . $scholarship->name)
@section('header_title', 'Submit Application')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4 d-flex align-items-center gap-3">
        <a href="{{ route('student.scholarships') }}" class="btn btn-icon btn-light rounded-circle shadow-sm">
            <i data-lucide="arrow-left" style="width: 20px;"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-1">Apply: {{ $scholarship->name }}</h4>
            <p class="text-muted mb-0">Fill out the requirements accurately to submit your application.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger bg-danger-subtle text-danger border-0 d-flex align-items-center gap-2 rounded-4 mb-4">
            <i data-lucide="alert-circle" style="width: 18px;"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Application Details Sidebar -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle sm bg-eskoylar-primary text-white me-3 shadow-sm">
                            <i data-lucide="graduation-cap" style="width:18px;height:18px;"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-body">Scholarship Details</h5>
                    </div>
                    
                    <hr class="text-secondary opacity-25">
                    
                    <h3 class="text-eskoylar-primary fw-bold mb-3">${{ number_format($scholarship->max_amount, 2) }}</h3>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">
                        {{ $scholarship->description ?? 'No description provided.' }}
                    </p>
                    
                    <div class="mb-3 bg-dark-subtle rounded p-3">
                        <div class="text-body text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Active Application Period</div>
                        <div class="d-flex align-items-center gap-2 text-sm pt-1">
                            <i data-lucide="calendar" style="width: 14px;" class="text-eskoylar-primary"></i>
                            <span class="text-body fw-medium">
                                {{ \Carbon\Carbon::parse($activePeriod->start_date)->format('M j, Y') }} 
                                - 
                                {{ \Carbon\Carbon::parse($activePeriod->end_date)->format('M j, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form id="applicationForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="scholarship_id" value="{{ $scholarship->id }}">

                        <h5 class="fw-bold mb-4 border-bottom pb-3"><i data-lucide="folder-up" class="text-eskoylar-primary me-2"></i> Upload Requirements</h5>
                        
                        @if($scholarship->requirements->count() > 0)
                            <div class="row g-4 mb-4">
                                @foreach($scholarship->requirements as $index => $req)
                                    <div class="col-12">
                                        <div class="requirement-box p-4 rounded-3 border border-secondary-subtle bg-light-subtle transition-all">
                                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                                <div>
                                                    <h6 class="fw-bold mb-1">
                                                        <span class="text-eskoylar-primary me-1">{{ $index + 1 }}.</span> {{ $req->name }}
                                                    </h6>
                                                    <small class="text-muted d-block">Please upload a clearly legible PDF, JPG, or PNG document (Max: 10MB).</small>
                                                </div>
                                                <div style="flex: 0 0 300px;">
                                                    <input type="file" 
                                                           class="form-control" 
                                                           name="requirements[{{ $req->id }}]" 
                                                           id="req_{{ $req->id }}" 
                                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info bg-info-subtle text-info border-0 d-flex align-items-center gap-2 rounded-4 mb-4">
                                <i data-lucide="info" style="width: 18px;"></i>
                                This physical scholarship doesn't have any explicitly mapped upload requirements! You can easily submit the application directly.
                            </div>
                        @endif

                        <hr class="text-secondary opacity-25">

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('student.scholarships') }}" class="btn btn-light fw-medium px-4">Cancel</a>
                            <button type="submit" class="btn btn-eskoylar-primary text-white fw-bold shadow-sm px-5" id="submitBtn">
                                Submit Application <i data-lucide="send" style="width: 16px;" class="ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
