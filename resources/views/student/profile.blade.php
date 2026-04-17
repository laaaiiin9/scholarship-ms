@extends('layouts.student')
@section('title', 'Profile')
@section('content')

    <section class="form-section d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-12 col-md-8">
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Update Profile</h2>
                            </div>

                            <form data-ajax-form method="POST" action="{{ route('student.profile.update') }}">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control shadow-none" id="first_name" name="first_name"
                                        placeholder="First Name" value="{{ old('first_name', $profile ? $profile->first_name : '') }}" required>
                                    <label for="first_name">First Name</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control shadow-none" id="last_name" name="last_name"
                                        placeholder="Last Name" value="{{ old('last_name', $profile ? $profile->last_name : '') }}" required>
                                    <label for="last_name">Last Name</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control shadow-none" id="school" name="school"
                                        placeholder="School" value="{{ old('school', $profile ? $profile->school : '') }}" required>
                                    <label for="school">School</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control shadow-none" id="course" name="course"
                                        placeholder="Course" value="{{ old('course', $profile ? $profile->course : '') }}" required>
                                    <label for="course">Course</label>
                                </div>

                                <button type="submit" class="btn-gradient w-100 py-2 fw-bold mb-3">Login</button>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Profile Overview</h2>
                            </div>

                            

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection