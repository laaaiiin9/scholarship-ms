@extends('layouts.main')
@section('title', 'Home')
@section('content')

    <section id="hero-section" class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center align-items-center gy-5">
                <div class="col-11 col-xl-10">
                    <div class="row align-items-center g-4 g-lg-0">

                        <div class="col-lg-6 pe-lg-5 text-center text-lg-start">
                            <h1 class="hero-title fw-bold display-3 mb-3">Eskoylar</h1>
                            <p class="hero-description fs-5 mb-4 text-secondary">
                                A centralized platform for students to apply, track, and manage scholarship
                                applications efficiently.
                            </p>
                            <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                                <button class="btn-bordered px-4 py-2">Apply Now</button>
                                <button class="btn-gradient px-4 py-2">Login</button>
                            </div>
                        </div>

                        <div class="col-lg-6 ps-lg-5">
                            <div class="hero-card-wrapper">
                                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                                    <div class="card-header bg-body-tertiary border-0 py-3 px-4">
                                        <div class="d-flex gap-2">
                                            <div class="bg-danger rounded-circle" style="width: 12px; height: 12px;"></div>
                                            <div class="bg-warning rounded-circle" style="width: 12px; height: 12px;"></div>
                                            <div class="bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <img src="{{ asset('assets/images/overview-hero.png') }}"
                                            alt="Dashboard Preview" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="stats-section" class="py-5">
        <div class="container py-lg-4">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center text-center">

                <div class="col">
                    <div class="stat-card p-4">
                        <div class="stat-icon mb-3">
                            <i data-lucide="graduation-cap" class="text-eskoylar-primary"></i>
                        </div>
                        <h2 class="fw-bold mb-1">25+</h2>
                        <p class="text-secondary fw-medium mb-0">Active Scholarships</p>
                    </div>
                </div>

                <div class="col">
                    <div class="stat-card p-4">
                        <div class="stat-icon mb-3">
                            <i data-lucide="users" class="text-eskoylar-primary"></i>
                        </div>
                        <h2 class="fw-bold mb-1">1,200+</h2>
                        <p class="text-secondary fw-medium mb-0">Registered Students</p>
                    </div>
                </div>

                <div class="col">
                    <div class="stat-card p-4">
                        <div class="stat-icon mb-3">
                            <i data-lucide="file-text" class="text-eskoylar-primary"></i>
                        </div>
                        <h2 class="fw-bold mb-1">3,500+</h2>
                        <p class="text-secondary fw-medium mb-0">Applications Submitted</p>
                    </div>
                </div>

                <div class="col">
                    <div class="stat-card p-4">
                        <div class="stat-icon mb-3">
                            <i data-lucide="check-circle" class="text-eskoylar-primary"></i>
                        </div>
                        <h2 class="fw-bold mb-1">800+</h2>
                        <p class="text-secondary fw-medium mb-0">Scholars Approved</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="features-section" class="py-5">
        <div class="container py-lg-5">
            <div class="text-center mb-5 mx-auto" style="max-width: 600px;">
                <h6 class="text-eskoylar-primary fw-bold text-uppercase tracking-wider">Features</h6>
                <h2 class="display-5 fw-bold">Everything you need to succeed</h2>
                <p class="text-secondary">We've simplified the scholarship process so you can focus on your studies,
                    not the paperwork.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 p-4 shadow-sm">
                        <div class="feature-icon-small bg-primary-subtle text-eskoylar-primary rounded-3 mb-4 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i data-lucide="search"></i>
                        </div>
                        <h4 class="fw-bold">Smart Search</h4>
                        <p class="text-secondary">Filter through hundreds of scholarships based on your course,
                            location, and financial needs.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 p-4 shadow-sm">
                        <div class="feature-icon-small bg-success-subtle text-success rounded-3 mb-4 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i data-lucide="file-check"></i>
                        </div>
                        <h4 class="fw-bold">Easy Application</h4>
                        <p class="text-secondary">Apply to multiple scholarships using a single profile. No more
                            filling out the same form twice.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 p-4 shadow-sm">
                        <div class="feature-icon-small bg-warning-subtle text-warning rounded-3 mb-4 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i data-lucide="bell"></i>
                        </div>
                        <h4 class="fw-bold">Real-time Tracking</h4>
                        <p class="text-secondary">Get instant notifications on your application status—from
                            submission to final approval.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="process-timeline" class="py-5">
        <div class="container py-lg-5">
            <div class="text-center mb-5 mx-auto" style="max-width: 600px;">
                <h2 class="display-5 fw-bold">Application Journey</h2>
                <p class="text-secondary">Track your progress transparently through every stage of the scholarship
                    cycle.</p>
            </div>

            <div class="timeline-container">
                <div class="row g-0 justify-content-center">

                    <div class="col-lg-2 col-md-4 timeline-item">
                        <div class="timeline-icon bg-primary text-white">
                            <i data-lucide="send"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="fw-bold mt-3">Submitted</h5>
                            <p class="text-muted fs-7">Documents received</p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 timeline-item">
                        <div class="timeline-icon bg-body text-eskoylar-primary border border-primary">
                            <i data-lucide="eye"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="fw-bold mt-3 text-eskoylar-primary">Under Review</h5>
                            <p class="text-muted fs-7">Initial screening</p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 timeline-item">
                        <div class="timeline-icon bg-body text-secondary border">
                            <i data-lucide="file-search"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="fw-bold mt-3">Evaluation</h5>
                            <p class="text-muted fs-7">Panel scoring</p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 timeline-item">
                        <div class="timeline-icon bg-body text-secondary border">
                            <i data-lucide="check-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="fw-bold mt-3">Approval</h5>
                            <p class="text-muted fs-7">Final selection</p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 timeline-item">
                        <div class="timeline-icon bg-body text-secondary border">
                            <i data-lucide="banknote"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="fw-bold mt-3">Release</h5>
                            <p class="text-muted fs-7">Fund disbursement</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection