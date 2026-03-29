<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="A smarter way to manage scholarship applications, screening, and student support.">
    <title>Home - {{ config('app.name') }}</title>

    <script>
        (() => {
            const storedTheme = localStorage.getItem('theme');
            const theme = storedTheme === 'light' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.style.colorScheme = theme;
        })();
    </script>

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
                <a class="navbar-brand brand-mark" href="{{ route('home') }}">
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

                    @auth
                        <div class="d-flex flex-column flex-lg-row gap-2 ms-lg-3">
                            <button class="btn btn-soft theme-toggle" type="button" id="theme-toggle"
                                aria-label="Switch to light theme" aria-pressed="false">
                                <span class="theme-toggle-icon" data-lucide="sun-moon"></span>
                            </button>

                            <div class="dropdown">
                                <button class="btn btn-soft profile-toggle dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="profile-toggle-icon" data-lucide="circle-user-round"></span>
                                    <span class="profile-toggle-name">
                                        {{ auth()->user()->username ?? auth()->user()->name }}
                                    </span>
                                    <span class="profile-toggle-caret" data-lucide="chevron-down"></span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                                    <li>
                                        <span class="dropdown-item-text profile-dropdown-user">
                                            {{ auth()->user()->username ?? auth()->user()->name }}
                                        </span>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('auth.logout') }}" id="btn-logout">Log Out</a></li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-column flex-lg-row gap-2 ms-lg-3">
                            <button class="btn btn-soft theme-toggle" type="button" id="theme-toggle"
                                aria-label="Switch to light theme" aria-pressed="false">
                                <span class="theme-toggle-icon" data-lucide="sun-moon"></span>
                            </button>
                            <a class="btn btn-soft" href="{{ route('auth.login') }}">Log In</a>
                            <a class="btn btn-custom-primary text-white btn-cta" href="{{ route('auth.register') }}">Get
                                Started</a>
                        </div>
                    @endauth

                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="site-footer-inner">
                <div class="container">
                    <div class="site-footer-panel">
                        <div class="site-footer-intro">
                            <a class="brand-mark site-footer-brand" href="#">
                                <span class="brand-mark-dot"></span>
                                <span>{{ config('app.name') }}</span>
                            </a>
                            <p class="site-footer-copy mb-0">
                                A clearer, more efficient way to manage scholarship applications, reviews, and student
                                support in one place.
                            </p>
                        </div>

                        <div class="site-footer-nav">
                            <div class="site-footer-column">
                                <span class="site-footer-heading">Platform</span>
                                <a href="#features">Features</a>
                                <a href="#how-it-works">How It Works</a>
                                <a href="#impact">Impact</a>
                            </div>

                            <div class="site-footer-column">
                                <span class="site-footer-heading">Resources</span>
                                <a href="#">Scholarships</a>
                                <a href="#">Eligibility</a>
                                <a href="#">FAQs</a>
                            </div>

                            <div class="site-footer-column">
                                <span class="site-footer-heading">Company</span>
                                <a href="#">About</a>
                                <a href="#">Contact</a>
                                <a href="#">Support</a>
                            </div>
                        </div>
                    </div>

                    <div class="site-footer-bottom">
                        <span>&copy; {{ date('Y') }} {{ config('app.name') }}</span>
                        <div class="site-footer-bottom-links">
                            <a href="#">Privacy Policy</a>
                            <a href="#">Terms of Service</a>
                            <a href="#">Help Center</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
