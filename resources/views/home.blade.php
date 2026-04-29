@extends('layouts.main')
@section('title', 'Home')
@section('content')

<section id="hero-section" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <!-- Decorative Blobs -->
    <div class="position-absolute top-0 start-0 translate-middle bg-primary opacity-10 rounded-circle" style="width: 600px; height: 600px; filter: blur(100px);"></div>
    <div class="position-absolute bottom-0 end-0 translate-middle bg-eskoylar-primary opacity-10 rounded-circle" style="width: 400px; height: 400px; filter: blur(80px);"></div>

    <div class="container position-relative">
        <div class="row justify-content-center align-items-center gy-5">
            <div class="col-11 col-xl-10">
                <div class="row align-items-center g-4 g-lg-0">

                    <div class="col-lg-6 pe-lg-5 text-center text-lg-start scroll-animate">
                        <div class="badge bg-primary-subtle text-eskoylar-primary px-3 py-2 rounded-pill mb-3 fw-bold">Empowering the Future</div>
                        <h1 class="hero-title fw-bold display-3 mb-3">Eskoylar</h1>
                        <p class="hero-description fs-5 mb-4 text-secondary">
                            A centralized ecosystem for students to discover, apply, and manage scholarship
                            opportunities with unprecedented ease.
                        </p>
                        <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                            @guest
                                <a href="{{ route('auth.register') }}" class="btn-gradient px-5 py-3 rounded-pill fw-bold shadow-lg text-decoration-none">Get Started</a>
                                <a href="{{ route('scholarships.public') }}" class="btn-bordered px-5 py-3 rounded-pill fw-bold text-decoration-none">Explore Programs</a>
                            @endguest
                            @auth
                                <a href="{{ route('scholarships.public') }}" class="btn-gradient px-5 py-3 rounded-pill fw-bold shadow-lg text-decoration-none">Explore Programs</a>
                            @endauth
                        </div>
                    </div>

                    <div class="col-lg-6 ps-lg-5 scroll-animate">
                        <div class="hero-card-wrapper">
                            <div class="card border-0 rounded-4 overflow-hidden hero-album-frame glass-card">
                                <div class="card-header bg-transparent border-0 py-3 px-4">
                                    <div class="d-flex gap-2">
                                        <div class="bg-danger rounded-circle" style="width: 12px; height: 12px;"></div>
                                        <div class="bg-warning rounded-circle" style="width: 12px; height: 12px;"></div>
                                        <div class="bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <img src="{{ asset('assets/images/overview2.png') }}"
                                        alt="Dashboard Overview" class="img-fluid" style="filter: brightness(0.9);">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Stats Section -->
<section id="stats-section" class="py-5 bg-dark position-relative">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3 scroll-animate">
                <div class="stat-card p-4">
                    <div class="stat-icon mb-2 text-eskoylar-primary">
                        <i data-lucide="graduation-cap"></i>
                    </div>
                    <h2 class="fw-bold mb-0">{{ number_format($stats['scholarships']) }}</h2>
                    <p class="text-secondary small text-uppercase tracking-wider">Programs</p>
                </div>
            </div>
            <div class="col-6 col-md-3 scroll-animate">
                <div class="stat-card p-4">
                    <div class="stat-icon mb-2 text-eskoylar-primary">
                        <i data-lucide="users"></i>
                    </div>
                    <h2 class="fw-bold mb-0">{{ number_format($stats['students']) }}</h2>
                    <p class="text-secondary small text-uppercase tracking-wider">Students</p>
                </div>
            </div>
            <div class="col-6 col-md-3 scroll-animate">
                <div class="stat-card p-4">
                    <div class="stat-icon mb-2 text-eskoylar-primary">
                        <i data-lucide="file-text"></i>
                    </div>
                    <h2 class="fw-bold mb-0">{{ number_format($stats['applications']) }}</h2>
                    <p class="text-secondary small text-uppercase tracking-wider">Applications</p>
                </div>
            </div>
            <div class="col-6 col-md-3 scroll-animate">
                <div class="stat-card p-4">
                    <div class="stat-icon mb-2 text-eskoylar-primary">
                        <i data-lucide="banknote"></i>
                    </div>
                    <h2 class="fw-bold mb-0">₱{{ number_format($stats['total_disbursed'] / 1000, 1) }}k+</h2>
                    <p class="text-secondary small text-uppercase tracking-wider">Funds Released</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features-section" class="py-5 position-relative overflow-hidden">
    <div class="container py-lg-5">
        <div class="text-center mb-5 scroll-animate">
            <span class="badge bg-primary-subtle text-eskoylar-primary px-3 py-2 rounded-pill mb-3 fw-bold">Platform Power</span>
            <h2 class="fw-bold display-5">Modern Scholarship Management</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">
                Eskoylar provides a comprehensive suite of tools designed to streamline the entire scholarship lifecycle for both students and administrators.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4 scroll-animate">
                <div class="card h-100 glass-card border-0 p-4">
                    <div class="feature-icon-small mb-4 text-eskoylar-primary">
                        <i data-lucide="layout-dashboard"></i>
                    </div>
                    <h4 class="fw-bold">Smart Dashboard</h4>
                    <p class="text-secondary small">A unified interface to track applications, deadlines, and notifications in real-time.</p>
                </div>
            </div>
            <div class="col-md-4 scroll-animate">
                <div class="card h-100 glass-card border-0 p-4">
                    <div class="feature-icon-small mb-4 text-eskoylar-primary">
                        <i data-lucide="shield-check"></i>
                    </div>
                    <h4 class="fw-bold">Secure Submissions</h4>
                    <p class="text-secondary small">End-to-end encrypted document management ensures your sensitive data stays private.</p>
                </div>
            </div>
            <div class="col-md-4 scroll-animate">
                <div class="card h-100 glass-card border-0 p-4">
                    <div class="feature-icon-small mb-4 text-eskoylar-primary">
                        <i data-lucide="zap"></i>
                    </div>
                    <h4 class="fw-bold">Fast Processing</h4>
                    <p class="text-secondary small">Automated workflows reduce approval times and speed up disbursement cycles.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section id="process-timeline" class="py-5 bg-dark">
    <div class="container py-lg-5">
        <div class="text-center mb-5 scroll-animate">
            <h2 class="fw-bold display-5">How It Works</h2>
            <p class="text-secondary">Your journey to academic success starts here.</p>
        </div>

        <div class="timeline-container">
            <div class="row">
                <div class="col-lg-3 timeline-item scroll-animate">
                    <div class="timeline-icon bg-eskoylar-primary text-white mb-3 shadow-lg">
                        <i data-lucide="search"></i>
                    </div>
                    <h5 class="fw-bold">1. Discover</h5>
                    <p class="text-secondary fs-7 px-3">Browse through various scholarship programs that match your profile.</p>
                </div>
                <div class="col-lg-3 timeline-item scroll-animate">
                    <div class="timeline-icon bg-eskoylar-primary text-white mb-3 shadow-lg">
                        <i data-lucide="edit-3"></i>
                    </div>
                    <h5 class="fw-bold">2. Apply</h5>
                    <p class="text-secondary fs-7 px-3">Complete application forms and upload necessary documents securely.</p>
                </div>
                <div class="col-lg-3 timeline-item scroll-animate">
                    <div class="timeline-icon bg-eskoylar-primary text-white mb-3 shadow-lg">
                        <i data-lucide="clipboard-check"></i>
                    </div>
                    <h5 class="fw-bold">3. Review</h5>
                    <p class="text-secondary fs-7 px-3">Administrators verify your documents and assess your eligibility.</p>
                </div>
                <div class="col-lg-3 timeline-item scroll-animate">
                    <div class="timeline-icon bg-eskoylar-primary text-white mb-3 shadow-lg">
                        <i data-lucide="award"></i>
                    </div>
                    <h5 class="fw-bold">4. Receive</h5>
                    <p class="text-secondary fs-7 px-3">Get awarded and manage your disbursements through your portal.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cookie Consent Banner -->
<div id="cookie-consent" class="cookie-banner position-fixed bottom-0 start-0 w-100 p-4 translate-middle-y opacity-0" style="z-index: 9999; pointer-events: none; transition: all 0.5s ease;">
    <div class="container">
        <div class="glass-card border-0 p-4 shadow-lg rounded-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
            <div class="d-flex align-items-center gap-3">
                <div class="cookie-icon text-eskoylar-primary">
                    <i data-lucide="cookie" style="width: 40px; height: 40px;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Cookie Preferences</h5>
                    <p class="text-secondary small mb-0">We use cookies to enhance your experience and ensure the security of our platform. By continuing to browse, you agree to our use of cookies.</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button id="accept-cookies" class="btn btn-gradient rounded-pill px-4 py-2 fw-bold">Accept All</button>
                <button class="btn btn-bordered rounded-pill px-4 py-2 fw-bold small" onclick="this.parentElement.parentElement.parentElement.parentElement.classList.add('hide')">Decline</button>
            </div>
        </div>
    </div>
</div>


<footer class="bg-dark text-white pt-4 pb-4 border-top border-secondary border-opacity-10">
    <div class="container">
        <div class="row gy-4">
            <!-- Brand & About -->
            <div class="col-lg-5 text-center text-lg-start">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo" height="32" class="mb-3" style="filter: brightness(0) invert(1);">
                <p class="small text-secondary mb-0" style="max-width: 400px;">
                    Eskoylar is a centralized platform dedicated to empowering students by simplifying the search and application process for scholarships.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div class="col-6 col-sm-4 col-lg-2 offset-lg-1">
                <h6 class="text-uppercase mb-3 fw-bold text-eskoylar-primary small" style="letter-spacing: 1px;">Links</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="#hero-section" class="text-secondary text-decoration-none small hover-text-primary transition-all">Home</a></li>
                    <li class="mb-2"><a href="#features-section" class="text-secondary text-decoration-none small hover-text-primary transition-all">Features</a></li>
                    <li class="mb-2"><a href="#process-timeline" class="text-secondary text-decoration-none small hover-text-primary transition-all">Process</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-6 col-sm-8 col-lg-4">
                <h6 class="text-uppercase mb-3 fw-bold text-eskoylar-primary small" style="letter-spacing: 1px;">Contact</h6>
                <div class="small text-secondary mb-2 d-flex align-items-center gap-2">
                    <i data-lucide="mail" style="width:14px;"></i> support.eskoylar@gmail.com
                </div>
                <div class="small text-secondary d-flex align-items-center gap-2">
                    <i data-lucide="map-pin" style="width:14px;"></i> Davao, Philippines
                </div>
            </div>
        </div>

        <hr class="my-4 border-secondary border-opacity-10">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-secondary mb-0">&copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong>. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item me-3"><a href="#" class="text-secondary small text-decoration-none hover-text-primary transition-all">Terms</a></li>
                    <li class="list-inline-item me-3"><a href="#" class="text-secondary small text-decoration-none hover-text-primary transition-all">Privacy</a></li>
                    <li class="list-inline-item"><a href="#" class="text-secondary small text-decoration-none hover-text-primary transition-all" data-bs-toggle="modal" data-bs-target="#cookiePolicyModal">Cookies</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Cookie Policy Modal -->
<div class="modal fade" id="cookiePolicyModal" tabindex="-1" aria-labelledby="cookiePolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card border-0 rounded-4">
            <div class="modal-header border-bottom border-secondary border-opacity-10 py-4 px-4">
                <h5 class="modal-title fw-bold" id="cookiePolicyModalLabel">
                    <i data-lucide="info" class="text-eskoylar-primary me-2"></i> Cookie & Privacy Policy
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <h6 class="fw-bold text-eskoylar-primary">What are cookies?</h6>
                    <p class="text-secondary small">Cookies are small text files that are placed on your computer or mobile device when you visit a website. They are widely used to make websites work more efficiently and provide information to the owners of the site.</p>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold text-eskoylar-primary">How we use them</h6>
                    <ul class="text-secondary small">
                        <li><strong>Essential Cookies:</strong> Necessary for the website to function, such as authentication and security.</li>
                        <li><strong>Performance Cookies:</strong> Help us understand how visitors interact with our website.</li>
                        <li><strong>Functional Cookies:</strong> Allow the website to remember choices you make (like your theme preference).</li>
                    </ul>
                </div>
                <div>
                    <h6 class="fw-bold text-eskoylar-primary">Is it necessary?</h6>
                    <p class="text-secondary small mb-0">Yes, certain cookies are essential for the core functionality of the Eskoylar platform, such as keeping you logged in and protecting your data. We respect your privacy and only use cookies that are required for a seamless experience.</p>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-bordered rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection