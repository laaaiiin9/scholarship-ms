@extends ('layouts.main')
@section('title', 'Home')

@section('content')
    <section class="hero-section hero-section-cover pb-5 pb-lg-7">
        <div class="hero-cover">
            <div class="container hero-cover-content">
                <div class="row align-items-center g-4 g-lg-5 hero-cover-grid">
                    <div class="col-12 col-lg-6">
                        <div class="hero-cover-copy">
                            <h1 class="hero-title mb-3">
                                <!-- Scholarship
                                    <span>Management</span>
                                    System -->
                                Eskoylar
                            </h1>

                            <p class="hero-copy mb-4">
                                Browse and apply for available scholarships that match your qualifications. Stay updated on
                                deadlines, requirements, and application status all in one place.
                            </p>

                            <div class="d-flex flex-column flex-sm-row gap-3">
                                @auth
                                    @if (Auth::user()->hasRole('student'))
                                        <a class="btn btn-custom-primary text-white btn-hero-primary" href="#">View My
                                            Applications</a>
                                        <a class="btn btn-light btn-hero-secondary" href="#features">Browse Scholarships</a>
                                    @else

                                    @endif

                                @else
                                    <a class="btn btn-custom-primary text-white btn-hero-primary"
                                        href="{{ route('auth.register') }}">Apply Now</a>
                                    <a class="btn btn-light btn-hero-secondary" href="#features">Browse Scholarships</a>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="hero-dashboard hero-sidecard ms-lg-auto">
                            <div class="hero-dashboard-top">
                                <p class="eyebrow mb-1">Scholarship Pulse</p>
                                <span class="status-pill">
                                    <span class="status-pill-dot"></span>
                                    Active cycle
                                </span>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <div class="info-tile">
                                        <span class="info-tile-label">Open Applications</span>
                                        <strong>1,248</strong>
                                        <small>submitted this term</small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="info-tile">
                                        <span class="info-tile-label">For Review</span>
                                        <strong>314</strong>
                                        <small>ready for validation</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="process-card hero-sidecard-highlight">
                                        <span class="process-card-step">72%</span>
                                        <div>
                                            <h3>Faster review flow</h3>
                                            <p>Move applicants from submission to screening with a clearer and more
                                                organized process.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="impact" class="stats-section py-4 py-lg-5">
        <div class="container">
            <div class="stats-strip">
                <div>
                    <span class="stats-strip-label">Built for clarity</span>
                    <h2>Everything teams need to review, verify, and award with confidence.</h2>
                </div>
                <div class="stats-grid">
                    <div class="stats-item">
                        <strong>24/7</strong>
                        <span>portal access</span>
                    </div>
                    <div class="stats-item">
                        <strong>100%</strong>
                        <span>digital workflow</span>
                    </div>
                    <div class="stats-item">
                        <strong>1 Hub</strong>
                        <span>for every document</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="feature-section py-5 py-lg-7">
        <div class="container">
            <div class="section-heading text-center mx-auto">
                <span class="section-heading-eyebrow">Features</span>
                <h2>Designed to reduce friction for both students and administrators</h2>
                <p>
                    Replace scattered forms and manual follow-ups with a guided, trackable process that feels
                    professional from start to finish.
                </p>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-12 col-md-6 col-xl-3">
                    <article class="feature-card h-100">
                        <div class="feature-card-icon" data-lucide="files"></div>
                        <h3>Smart submissions</h3>
                        <p>Let students upload requirements in one place with a cleaner, less confusing form flow.</p>
                    </article>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <article class="feature-card h-100">
                        <div class="feature-card-icon" data-lucide="search-check"></div>
                        <h3>Faster screening</h3>
                        <p>Review eligibility, completeness, and scholarship fit without bouncing between tools.</p>
                    </article>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <article class="feature-card h-100">
                        <div class="feature-card-icon" data-lucide="bell-ring"></div>
                        <h3>Status visibility</h3>
                        <p>Keep applicants informed with clearer progress states and less back-and-forth messaging.</p>
                    </article>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <article class="feature-card h-100">
                        <div class="feature-card-icon" data-lucide="chart-column-big"></div>
                        <h3>Actionable insights</h3>
                        <p>Track volumes, bottlenecks, and outcomes so the next scholarship cycle runs even better.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="process-section py-5 py-lg-7">
        <div class="container">
            <div class="row align-items-start g-4 g-lg-5">
                <div class="col-12 col-lg-5">
                    <span class="section-heading-eyebrow">How It Works</span>
                    <h2 class="process-title">A straightforward flow that feels easier at every step</h2>
                    <p class="process-copy">
                        The experience is structured to guide applicants while helping your team make faster,
                        more consistent decisions.
                    </p>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="process-stack">
                        <article class="process-card">
                            <span class="process-card-step">01</span>
                            <div>
                                <h3>Create and submit</h3>
                                <p>Applicants register once, complete their profile, and send all required documents through
                                    one guided portal.</p>
                            </div>
                        </article>
                        <article class="process-card">
                            <span class="process-card-step">02</span>
                            <div>
                                <h3>Review and validate</h3>
                                <p>Administrators screen entries, verify missing requirements, and organize shortlisted
                                    candidates more efficiently.</p>
                            </div>
                        </article>
                        <article class="process-card">
                            <span class="process-card-step">03</span>
                            <div>
                                <h3>Track and award</h3>
                                <p>Teams monitor progress, update statuses, and keep scholars informed through a more
                                    transparent awarding process.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section pb-5 pb-lg-7">
        <div class="container">
            <div class="cta-panel">
                <div>
                    <span class="section-heading-eyebrow">Ready to launch</span>
                    <h2>Give your scholarship program a homepage that feels credible, modern, and easy to trust.</h2>
                    <p>Start with a clearer first impression and a smoother flow for every student who visits.</p>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a class="btn btn-light btn-hero-secondary" href="#">Request Demo</a>
                    <a class="btn btn-custom-primary text-white btn-hero-primary" href="#">Start Now</a>
                </div>
            </div>
        </div>
    </section>
@endsection