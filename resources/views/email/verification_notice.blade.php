@extends('layouts.main')
@section('title', 'Verify Email')
@section('content')

    <section class="form-section d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">{{ config('app.name') }}</h2>
                                <p class="text-secondary small">Before continuing, please verify your email address using
                                    the link we sent you after
                                    registration.</p>
                            </div>

                            <form data-ajax-form method="POST" action="{{ route('verification.send') }}">
                                <button type="submit" class="btn-gradient w-100 py-2 fw-bold mb-3">Resend Verification</button>
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