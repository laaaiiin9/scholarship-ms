@extends ('layouts.main')
@section('title', 'Email Verified')

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
                                    <h2>Email verified successfully</h2>
                                </div>
                                <span class="status-pill">Completed</span>
                            </div>

                            <div class="alert alert-success mb-4" role="alert">
                                Your email has been successfully verified.
                            </div>

                            <p class="mb-0" style="color: var(--ink-soft);">
                                You can now close this page and continue.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
