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
                <a href="{{ route('admin.dashboard', [], false) ?? '/' }}" class="text-decoration-none offcanvas-title">
                    <div class="logo-icon"></div>
                </a>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column p-0 h-100">
                <div class="p-4 mb-2 text-center d-none d-lg-block">
                    <a href="{{ route('admin.dashboard', [], false) ?? '/' }}" class="text-decoration-none">
                        <div class="logo-icon mx-auto"></div>
                    </a>
                </div>
                
                <ul class="nav nav-pills flex-column mb-auto px-3 mt-4 mt-lg-2">
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard', [], false) ?? '#' }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }} d-flex align-items-center" aria-current="page">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="layout-dashboard" style="width: 20px;"></i></span> Dashboard
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.scholarships') }}" class="nav-link {{ Route::is('admin.scholarships') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="book-open" style="width: 20px;"></i></span> Scholarships
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.requirements') }}" class="nav-link {{ Route::is('admin.requirements') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="check-square" style="width: 20px;"></i></span> Requirements
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.application-periods') }}" class="nav-link {{ Route::is('admin.application-periods') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="calendar" style="width: 20px;"></i></span> Application Periods
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.renewal-periods.list') }}" class="nav-link {{ Route::is('admin.renewal-periods.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="refresh-cw" style="width: 20px;"></i></span> Renewal Periods
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.applications.index') }}" class="nav-link {{ Route::is('admin.applications.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="file-text" style="width: 20px;"></i></span> Applications
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.renewals.list') }}" class="nav-link {{ Route::is('admin.renewals.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="refresh-cw" style="width: 20px;"></i></span> Renewal Submissions
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.disbursements.list') }}" class="nav-link {{ Route::is('admin.disbursements.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="dollar-sign" style="width: 20px;"></i></span> Disbursements
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ Route::is('admin.users.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="users" style="width: 20px;"></i></span> User Management
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ Route::is('admin.reports.*') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="pie-chart" style="width: 20px;"></i></span> Reports & Analytics
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ Route::is('admin.notifications.index') ? 'active' : '' }} d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center me-3" style="width: 24px;"><i data-lucide="bell" style="width: 20px;"></i></span> Notifications
                        </a>
                    </li>

                </ul>

                <hr class="text-white-50 mx-3 my-2">
                
                <div class="px-3 pb-4">
                    <form method="POST" action="{{ route('auth.logout') }}" data-ajax-form>
                        @csrf
                        <button type="submit" class="nav-link text-danger d-flex align-items-center mt-2 border-0 bg-transparent w-100 text-start px-0">
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
                    <form class="d-none d-md-flex" role="search">
                        <div class="position-relative">
                            <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                            <input class="form-control ps-5 rounded-pill" type="search" placeholder="Search..." aria-label="Search">
                        </div>
                    </form>

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
                                <a href="{{ route('admin.notifications.index') }}" class="text-muted small text-decoration-none">View all notifications</a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none hide-caret dropdown-toggle gap-2" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,12">
                            <div class="text-end d-none d-md-block me-1">
                                <p class="mb-0 text-sm fw-medium lh-1 text-body">{{ auth()->user()->username }}</p>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->roles->first()->name ?? 'Administrator' }}</small>
                            </div>
                            <div class="avatar-circle">{{ strtoupper(substr(auth()->user()->username, 0, 1)) }}</div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4" aria-labelledby="dropdownUser">
                            <li><span class="dropdown-item-text small text-muted">Admin Account</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('auth.logout') }}" data-ajax-form>
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 border-0 bg-transparent w-100 text-start">
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
                @yield('content')
            </section>
        </main>
    </div>

    @stack('scripts')
</body>

</html>
