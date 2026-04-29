<header class="sticky-top">
    <nav class="navbar navbar-expand-lg bg-body-transparent">
        <div class="container-fluid mx-0 mx-sm-5">

            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="{{ config('app.name') }}" height="40" style="filter: brightness(0) invert(1);">
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#eskoylarOffcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="eskoylarOffcanvas"
                aria-labelledby="offcanvasLabel">
                <div class="offcanvas-header border-bottom border-secondary">
                    <h5 class="offcanvas-title" id="offcanvasLabel">{{ config('app.name') }}</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body px-5 px-lg-0">
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <ul
                        class="navbar-nav mx-lg-auto mb-4 mb-lg-0 gap-2 gap-lg-3 align-items-start align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#stats-section">Stats</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features-section">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#process-timeline">Process</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-lg-auto gap-3 align-items-start align-items-lg-center">
                        <li class="nav-item">
                            <button class="btn btn-icon theme-toggle d-flex align-items-center gap-2 p-2 rounded-circle hover-bg shadow-none border-0" type="button" title="Toggle Theme">
                                <i data-lucide="sun" class="theme-icon-active" style="width: 20px; height: 20px;"></i>
                            </button>
                        </li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="btn-bordered d-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-pill dropdown-toggle hide-caret shadow-sm" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-offset="0,6" style="text-decoration: none;">
                                    <div class="avatar-circle sm bg-eskoylar-primary text-white m-0 p-0 overflow-hidden" style="width: 24px; height: 24px; font-size: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                                        @if(auth()->user()->profile_picture)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="w-100 h-100 object-fit-cover rounded-circle">
                                        @else
                                            {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="fw-bold text-sm">{{ auth()->user()->username }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 glass-card py-2 overflow-hidden" style="min-width: 200px;">
                                    <li class="px-3 py-2 border-bottom border-secondary border-opacity-10 mb-1">
                                        <div class="text-xs text-muted text-uppercase fw-bold tracking-wider">Account Settings</div>
                                    </li>
                                    @if(!auth()->user()->hasRole('admin'))
                                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('student.profile') }}"><i data-lucide="user" style="width: 16px;"></i> Profile Settings</a></li>
                                    @endif
                                    @if(auth()->user()->hasRole('admin'))
                                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('admin.dashboard') }}"><i data-lucide="layout-dashboard" style="width: 16px;"></i> Admin Dashboard</a></li>
                                    @elseif(auth()->user()->hasRole('student'))
                                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('student.dashboard') }}"><i data-lucide="layout-dashboard" style="width: 16px;"></i> Student Dashboard</a></li>
                                    @endif
                                    
                                    <li><hr class="dropdown-divider opacity-10"></li>
                                    <li>
                                        <form data-ajax-form method="POST" action="{{ route('auth.logout') }}" class="d-inline p-0 m-0 w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 w-100 border-0 bg-transparent text-start">
                                                <i data-lucide="log-out" style="width: 16px;"></i> Logout Session
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item w-100">
                                <a class="btn-bordered d-block text-center" href="{{ route('auth.login') }}">Login</a>
                            </li>
                            <li class="nav-item w-100">
                                <a class="btn-gradient d-block text-center" href="{{ route('auth.register') }}">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>