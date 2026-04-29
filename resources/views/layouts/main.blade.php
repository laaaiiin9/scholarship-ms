<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '') - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <script>
        (function() {
            const storedTheme = localStorage.getItem('theme') || 'dark'; // default to dark
            document.documentElement.setAttribute('data-bs-theme', storedTheme);
        })();
    </script>
</head>

<body data-success="{{ session('success') }}" data-error="{{ session('error') }}">

    <x-navbar></x-navbar>

    <main class="min-vh-100">
        @if(auth()->check() && auth()->user()->hasRole('STUDENT') && !auth()->user()->hasVerifiedEmail())
        <div class="alert alert-warning border-0 rounded-0 shadow-sm mb-0 p-2 text-center small fw-medium">
            <i data-lucide="mail-warning" style="width: 14px;" class="me-2"></i>
            Your email is unverified. Please check your inbox.
            <button id="resendVerificationBtnMain" class="btn btn-link btn-sm p-0 ms-2 text-warning fw-bold text-decoration-none">Resend Email</button>
        </div>
        @endif
        @yield('content')
    </main>

</body>

</html>