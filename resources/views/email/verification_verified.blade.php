@extends('layouts.main')
@section('title', 'Email Verified')
@section('content')

    <section class="form-section d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 p-5 text-center">
                        <div class="card-body">
                            <div class="avatar-circle mx-auto bg-success-subtle text-success mb-4" style="width: 80px; height: 80px;">
                                <i data-lucide="check-circle" style="width: 40px;"></i>
                            </div>
                            <h2 class="fw-bold mb-3">Email Verified!</h2>
                            <p class="text-secondary mb-4">Your email address has been successfully verified. You can now access all features, including scholarship applications.</p>
                            
                            <a href="{{ route('student.dashboard') }}" class="btn-gradient w-100 py-3 fw-bold text-decoration-none d-inline-block">
                                Go to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
