@extends ('layouts.main')
@section('title', 'Verify Email')

@section('content')
    <section class="register-section py-5 py-lg-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-7">
                    <div class="register-shell">
                        <div class="register-card h-100">
                            <div class="register-card-header">
                                <div>
                                    <p class="eyebrow mb-1">Email Verification</p>
                                    <h2>Check your inbox</h2>
                                </div>
                                <span class="status-pill">Action Required</span>
                            </div>

                            <p class="mb-3" style="color: var(--ink-soft);">
                                Before continuing, please verify your email address using the link we sent you after
                                registration.
                            </p>

                            <p class="mb-4" style="color: var(--ink-soft);">
                                If you did not receive the email, you can request another verification link below.
                            </p>

                            <div class="register-actions d-flex flex-column flex-sm-row align-items-sm-center gap-3">
                                <form id="verificationForm" method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button class="btn btn-custom-primary text-white" type="submit">
                                        Resend Verification Email
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
