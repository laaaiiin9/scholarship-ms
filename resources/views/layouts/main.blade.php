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
        
        @include('components.navbar')

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