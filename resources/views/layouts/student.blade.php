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

</head>

<body data-success="{{ session('success') }}" data-error="{{ session('error') }}">

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar bg-dark offcanvas-lg offcanvas-start" tabindex="-1" id="sidebarMenu">
            <div class="offcanvas-header border-bottom border-dark-subtle p-3">
                <a href="{{ route('student.dashboard', [], false) ?? '/' }}" class="text-decoration-none offcanvas-title">
                    <div class="logo-icon"></div>
                </a>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column p-0 h-100">
                <div class="p-4 mb-2 text-center d-none d-lg-block">
                    <a href="{{ route('student.dashboard', [], false) ?? '/' }}" class="text-decoration-none">
                        <div class="logo-icon mx-auto"></div>
                    </a>
                </div>
                
                <ul class="nav nav-pills flex-column mb-auto px-3 mt-4 mt-lg-2">
                    <li class="nav-item mb-2">
                        <a href="{{ route('student.dashboard') }}" class="nav-link {{ Route::is('student.dashboard') ? 'active' : '' }} d-flex align-items-center" aria-current="page">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="layout-dashboard" style="width: 20px;"></i></span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('student.scholarships') }}" class="nav-link {{ Route::is('student.scholarships') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="search" style="width: 20px;"></i></span> Find Scholarships
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('student.applications.index') }}" class="nav-link {{ Route::is('student.applications.*') && !Route::is('student.renewals.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="file-text" style="width: 20px;"></i></span> My Applications
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('student.renewals.index') }}" class="nav-link {{ Route::is('student.renewals.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="refresh-cw" style="width: 20px;"></i></span> Renew Scholarship
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('student.notifications.index') }}" class="nav-link {{ Route::is('student.notifications.index') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="bell" style="width: 20px;"></i></span> Notifications
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('student.profile') }}" class="nav-link {{ Route::is('student.profile') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="user" style="width: 20px;"></i></span> My Profile
                        </a>
                    </li>
                </ul>

                <hr class="text-white-50 mx-3 my-2">
                
                <div class="px-3 pb-4">
                    <form action="{{ route('auth.logout') }}" method="POST" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="btn nav-link text-danger d-flex align-items-center w-100 text-start shadow-none mt-2">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="log-out" style="width: 20px;"></i></span> Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <nav class="dashboard-nav px-3 px-md-4 d-flex align-items-center justify-content-between sticky-top">
                <div class="d-flex align-items-center gap-2">
                    <!-- Mobile toggle button -->
                    <button class="btn btn-icon d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                        <i data-lucide="menu"></i>
                    </button>
                    <div class="d-none d-md-block">
                        <h5 class="mb-0 fw-semibold text-capitalize">@yield('header_title', 'Dashboard')</h5>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    {{-- Notification Bell --}}
                    <div class="dropdown">
                        <button class="btn btn-icon position-relative" id="notifBellBtn" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-offset="0,12">
                            <i data-lucide="bell" style="width: 20px; height: 20px;"></i>
                            <span id="notif-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-flex align-items-center justify-content-center" style="font-size:0.6rem;min-width:18px;height:18px;display:none!important;">0</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0 rounded-4" style="min-width:280px; max-width: 320px; max-height:400px; overflow-y:auto;">
                            <div class="d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                                <span class="fw-bold small">Notifications</span>
                                <button id="notif-mark-all-btn" class="btn btn-link btn-sm text-muted text-decoration-none shadow-none p-0" style="font-size:0.75rem;">Mark all read</button>
                            </div>
                            <ul id="notif-dropdown-list" class="list-unstyled mb-0">
                                <li class="px-3 py-4 text-center text-muted small">Loading...</li>
                            </ul>
                            <div class="border-top text-center py-2">
                                <a href="{{ route('student.notifications.index') }}" class="text-muted small text-decoration-none">View all notifications</a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none hide-caret dropdown-toggle gap-2" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,12">
                            <div class="text-end d-none d-md-block me-1">
                                <p class="mb-0 text-sm fw-medium lh-1 text-body">{{ auth()->user()->name ?? 'Student' }}</p>
                                <small class="text-muted" style="font-size: 0.75rem;">Scholar</small>
                            </div>
                            <div class="avatar-circle">{{ substr(auth()->user()->name ?? 'S', 0, 1) }}</div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4" aria-labelledby="dropdownUser">
                            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('student.profile') }}"><i data-lucide="user" style="width: 16px;"></i> My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 shadow-none">
                                        <i data-lucide="log-out" style="width: 16px;"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content Section -->
            <section class="p-3 p-md-4">
                @if(auth()->check() && !auth()->user()->hasVerifiedEmail())
                <div class="alert alert-warning border-warning-subtle rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle sm bg-warning text-white">
                            <i data-lucide="mail-warning" style="width: 18px;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Email Verification Required</h6>
                            <p class="mb-0 small text-muted">Please check your inbox to verify your account. You cannot apply for scholarships until verified.</p>
                        </div>
                    </div>
                    <div>
                        <button id="resendVerificationBtn" class="btn btn-warning btn-sm px-3 rounded-3 text-white fw-bold shadow-sm">
                            Resend Email
                        </button>
                    </div>
                </div>
                @endif
                
                @yield('content')
            </section>
        </main>
    </div>

    @stack('scripts')
</body>

</html>
