<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A smarter way to manage scholarship applications, screening, and student support.">
    <title>Home - {{ config('app.name') }}</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
</head>

<body class="landing-page">
    <div class="page-shell">
        <nav class="navbar navbar-expand-lg main-navbar py-3">
            <div class="container">
                <a class="navbar-brand brand-mark" href="#">
                    <span class="brand-mark-dot"></span>
                    <span>{{ config('app.name') }}</span>
                </a>

                <button id="navbar-toggler" class="navbar-toggler collapsed border-0 shadow-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span id="toggler-icon" data-lucide="Menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav mx-auto mb-3 mb-lg-0 nav-pill-group">
                        <li class="nav-item">
                            <a class="nav-link" href="#how-it-works">How It Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#impact">Impact</a>
                        </li>
                    </ul>

                    <div class="d-flex flex-column flex-lg-row gap-2 ms-lg-3">
                        <a class="btn btn-outline-light btn-soft" href="#">Log In</a>
                        <a class="btn btn-custom-primary text-white btn-cta" href="#">Get Started</a>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <section class="hero-section py-5 py-lg-7">
                <div class="container">
                    <div class="row align-items-center g-4 g-lg-5">
                        <div class="col-12 col-lg-6">
                            <span class="hero-badge">Empowering Futures</span>

                            <h1 class="hero-title mt-4 mb-3">
                                Scholarship
                                <span>Management</span>
                                System
                            </h1>

                            <p class="hero-copy mb-4">
                                Centralize applications, track requirements, review students faster, and give scholars a
                                more confident experience from first click to final approval.
                            </p>

                            <div class="d-flex flex-column flex-sm-row gap-3 mb-4">
                                <a class="btn btn-custom-primary text-white btn-hero-primary" href="#">Apply Now</a>
                                <a class="btn btn-light btn-hero-secondary" href="#features">Register</a>
                            </div>

                            <div class="hero-metrics row row-cols-1 row-cols-sm-3 g-3">
                                <div class="col">
                                    <div class="metric-card">
                                        <strong>3x Faster</strong>
                                        <span>application review flow</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="metric-card">
                                        <strong>Less Paperwork</strong>
                                        <span>through centralized submissions</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="metric-card">
                                        <strong>Clear Status</strong>
                                        <span>for admins and applicants</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="hero-visual">
                                <div class="hero-dashboard">
                                    <div class="hero-dashboard-top">
                                        <div>
                                            <p class="eyebrow mb-1">Dashboard Overview</p>
                                        </div>
                                        <span class="status-pill">
                                            <span class="status-pill-dot"></span>
                                            Live updates
                                        </span>
                                    </div>

                                    <div class="hero-dashboard-preview">
                                        <img class="hero-dashboard-image" src="{{ asset('assets/images/Gato.jpg') }}"
                                            alt="Scholarship platform preview">
                                    </div>

                                    <div class="row g-3 mt-1">
                                        <div class="col-6">
                                            <div class="info-tile">
                                                <span class="info-tile-label">Applications</span>
                                                <strong>1,248</strong>
                                                <small>active this cycle</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-tile">
                                                <span class="info-tile-label">Completion Rate</span>
                                                <strong>92%</strong>
                                                <small>with guided checklist</small>
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
                                        <p>Applicants register once, complete their profile, and send all required documents through one guided portal.</p>
                                    </div>
                                </article>
                                <article class="process-card">
                                    <span class="process-card-step">02</span>
                                    <div>
                                        <h3>Review and validate</h3>
                                        <p>Administrators screen entries, verify missing requirements, and organize shortlisted candidates more efficiently.</p>
                                    </div>
                                </article>
                                <article class="process-card">
                                    <span class="process-card-step">03</span>
                                    <div>
                                        <h3>Track and award</h3>
                                        <p>Teams monitor progress, update statuses, and keep scholars informed through a more transparent awarding process.</p>
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
        </main>
    </div>
</body>

</html>
