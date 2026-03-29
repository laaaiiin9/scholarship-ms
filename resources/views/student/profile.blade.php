@extends ('layouts.main')
@section ('title', 'Profile')

@section('content')
    <section class="py-5 py-lg-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-7">
                    <div class="register-shell">
                        <div class="register-card h-100">
                            <div class="register-card-header">
                                <div>
                                    <p class="eyebrow mb-1">Student Profile</p>
                                    <h2>{{ $profile ? 'Update your profile' : 'Complete your profile' }}</h2>
                                </div>
                                <span class="status-pill">Profile Details</span>
                            </div>

                            @if (!$profile)
                                <div class="alert alert-warning mb-4" role="alert">
                                    No profile found yet. Fill out the form below to create your profile.
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="alert alert-success mb-4" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form id="profileForm" method="POST" action="{{ route('student.profile.save') }}" novalidate>
                                @csrf

                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label register-label" for="first_name">First Name</label>
                                        <input class="form-control register-input" id="first_name" name="first_name"
                                            type="text" placeholder="Enter your first name"
                                            value="{{ old('first_name', $profile->first_name ?? '') }}" required>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label register-label" for="last_name">Last Name</label>
                                        <input class="form-control register-input" id="last_name" name="last_name"
                                            type="text" placeholder="Enter your last name"
                                            value="{{ old('last_name', $profile->last_name ?? '') }}" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label register-label" for="school">School</label>
                                        <input class="form-control register-input" id="school" name="school"
                                            type="text" placeholder="Enter your school"
                                            value="{{ old('school', $profile->school ?? '') }}" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label register-label" for="course">Course</label>
                                        <input class="form-control register-input" id="course" name="course"
                                            type="text" placeholder="Enter your course"
                                            value="{{ old('course', $profile->course ?? '') }}" required>
                                    </div>
                                </div>

                                <div class="register-actions">
                                    <button class="btn btn-custom-primary text-white" type="submit">Save Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
