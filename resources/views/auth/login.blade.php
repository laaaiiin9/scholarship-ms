@extends('layouts.main')
@section('title', 'Login')
@section('content')

    <section class="form-section d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">{{ config('app.name') }}</h2>
                                <p class="text-secondary small">Welcome back! Please login to your account.</p>
                            </div>

                            <form data-ajax-form method="POST" action="{{ route('auth.signin') }}">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control shadow-none" id="email" name="email"
                                        placeholder="name@example.com" required>
                                    <label for="email">Email address</label>
                                </div>

                                <div class="form-floating mb-3 position-relative">
                                    <input type="password" class="form-control shadow-none pe-5" id="password" name="password"
                                        placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" style="z-index: 10;">
                                        <i data-lucide="eye" style="width: 20px; color: #6c757d;"></i>
                                    </button>
                                </div>

                                <div class="d-flex justify-content-end align-items-center mb-4">
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
                                </div>

                                <button type="submit" class="btn-gradient w-100 py-2 fw-bold mb-3">Login</button>

                                <p class="text-center small mb-0">
                                    Don't have an account?
                                    <a href="{{ route('auth.register') }}" class="text-decoration-none fw-bold">Sign up</a>
                                </p>
                            </form>

                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="text-secondary text-decoration-none small">
                            <i data-lucide="arrow-left" class="me-1" style="width: 14px;"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection