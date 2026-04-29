@extends('layouts.main')
@section('title', 'Reset Password')
@section('content')

    <section class="form-section d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">New Password</h2>
                                <p class="text-secondary small">Enter your new password below.</p>
                            </div>

                            <form data-ajax-form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ request('email') }}">

                                <div class="form-floating mb-3 position-relative">
                                    <input type="password" class="form-control shadow-none pe-5" id="password" name="password"
                                        placeholder="New Password" required>
                                    <label for="password">New Password</label>
                                    <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" style="z-index: 10;">
                                        <i data-lucide="eye" style="width: 20px; color: #6c757d;"></i>
                                    </button>
                                </div>
                                
                                <div class="form-floating mb-4 position-relative">
                                    <input type="password" class="form-control shadow-none pe-5" id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirm Password" required>
                                    <label for="password_confirmation">Confirm Password</label>
                                    <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" style="z-index: 10;">
                                        <i data-lucide="eye" style="width: 20px; color: #6c757d;"></i>
                                    </button>
                                </div>

                                <button type="submit" class="btn-gradient w-100 py-2 fw-bold mb-3">Reset Password</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
