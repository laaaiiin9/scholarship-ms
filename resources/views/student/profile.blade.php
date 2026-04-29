@extends('layouts.student')
@section('title', 'Profile')
@section('header_title', 'My Profile')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <!-- Left: Profile Settings Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-1">Account & Personal Information</h5>
                    <p class="text-muted small">Update your identity details and contact information for scholarship validation.</p>
                </div>
                <div class="card-body p-4">
                    <form id="profileForm">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label text-sm fw-medium">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                    value="{{ old('first_name', $profile->first_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label text-sm fw-medium">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                    value="{{ old('last_name', $profile->last_name ?? '') }}" required>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label text-sm fw-medium">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="" disabled {{ !($profile->gender ?? '') ? 'selected' : '' }}>Select Gender</option>
                                    <option value="Male" {{ ($profile->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ ($profile->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ ($profile->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    <option value="Prefer not to say" {{ ($profile->gender ?? '') == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label text-sm fw-medium">Birth Date</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" 
                                    value="{{ old('birth_date', $profile->birth_date ?? '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label text-sm fw-medium">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" 
                                placeholder="+63 9xx xxx xxxx" value="{{ old('contact_number', $profile->contact_number ?? '') }}">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="school" class="form-label text-sm fw-medium">Educational Institution</label>
                                <input type="text" class="form-control" id="school" name="school" 
                                    placeholder="Name of your University/School" value="{{ old('school', $profile->school ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="course" class="form-label text-sm fw-medium">Course / Program</label>
                                <input type="text" class="form-control" id="course" name="course" 
                                    placeholder="e.g. BS Information Technology" value="{{ old('course', $profile->course ?? '') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label text-sm fw-medium">Home Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                placeholder="Street, City, Province, ZIP Code">{{ old('address', $profile->address ?? '') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-eskoylar-primary text-white px-5 py-2 rounded-3 shadow-sm" id="submitBtn">
                                <i data-lucide="save" style="width: 18px;" class="me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Profile Overview -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                <div class="card-body">
                    <div class="mb-4 position-relative d-inline-block">
                        <div class="avatar-circle mx-auto bg-eskoylar-primary bg-opacity-10 text-eskoylar-primary overflow-hidden" style="width: 100px; height: 100px; font-size: 2.5rem;" id="profileAvatarContainer">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="w-100 h-100 object-fit-cover" id="profileAvatar">
                            @else
                                <span id="avatarLetter">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="position-absolute bottom-0 end-0">
                            <form id="profilePictureForm" enctype="multipart/form-data">
                                <input type="file" name="profile_picture" id="profilePictureInput" class="d-none" accept="image/*">
                                <button type="button" class="btn btn-eskoylar-primary btn-icon rounded-circle shadow-sm border-2 border-white" style="width: 32px; height: 32px;" id="uploadPictureBtn">
                                    <i data-lucide="camera" style="width: 16px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h4 class="fw-bold mb-1 text-body">{{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-4 small">{{ auth()->user()->email }}</p>

                    <div class="bg-body-tertiary rounded-4 p-3 mb-4 border border-secondary-subtle">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Account Status:</span>
                            @if(auth()->user()->hasVerifiedEmail())
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2">Verified</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2">Not Verified</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">Member Since:</span>
                            <span class="fw-medium text-body">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    @php
                        $progress = 0;
                        if(auth()->user()->profile) $progress += 40;
                        if(auth()->user()->hasVerifiedEmail()) $progress += 30;
                        if(auth()->user()->applications()->exists()) $progress += 30;
                    @endphp

                    <div class="text-start mb-4">
                        <h6 class="fw-bold mb-3 small text-uppercase" style="letter-spacing: 1px;">Scholarship Progress</h6>
                        <div class="mb-2 d-flex justify-content-between small">
                            <span class="text-muted">General Progress</span>
                            <span class="fw-bold text-eskoylar-primary">{{ $progress }}%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px;">
                            <div class="progress-bar bg-eskoylar-primary rounded-pill progress-bar-striped progress-bar-animated" role="progressbar" style="width: calc({{ $progress }} * 1%);"></div>
                        </div>
                    </div>

                    <div class="pt-3 border-top">
                        <p class="text-muted small mb-0">
                            @if(auth()->user()->hasVerifiedEmail()) <i data-lucide="check-circle" class="text-success" style="width:14px;"></i> Identity Verified @else <i data-lucide="x-circle" class="text-danger" style="width:14px;"></i> Identity Not Verified @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection