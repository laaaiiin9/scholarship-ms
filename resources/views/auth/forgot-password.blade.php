@extends('layouts.main')
@section('title', 'Forgot Password')
@section('content')

    <section class="form-section d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Reset Password</h2>
                                <p class="text-secondary small">Enter your email and we'll send you instructions to reset your password.</p>
                            </div>

                            <form data-ajax-form method="POST" action="{{ route('password.email') }}" data-reset-on-success="true">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control shadow-none" id="email" name="email"
                                        placeholder="name@example.com" required>
                                    <label for="email">Email address</label>
                                </div>

                                <button type="submit" class="btn-gradient w-100 py-2 fw-bold mb-3">Send Reset Link</button>
                            </form>

                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('auth.login') }}" class="text-secondary text-decoration-none small">
                            <i data-lucide="arrow-left" class="me-1" style="width: 14px;"></i> Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
