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
                        @auth
                            <li class="nav-item dropdown w-100">
                                <a class="btn-bordered d-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-pill" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="text-decoration: none;">
                                    <div class="avatar-circle sm bg-secondary-subtle text-body m-0 p-0" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                                    </div>
                                    <span class="fw-medium text-sm">{{ auth()->user()->username }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-4">
                                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('student.profile') }}"><i data-lucide="user" style="width: 16px;"></i> Profile</a></li>
                                    @if(auth()->user()->hasRole('admin'))
                                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('admin.dashboard') }}"><i data-lucide="layout-dashboard" style="width: 16px;"></i> Admin Dashboard</a></li>
                                    @elseif(auth()->user()->hasRole('student'))
                                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('student.dashboard') }}"><i data-lucide="layout-dashboard" style="width: 16px;"></i> Dashboard</a></li>
                                    @endif
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form data-ajax-form method="POST" action="{{ route('auth.logout') }}" class="d-inline p-0 m-0 w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 w-100 border-0 bg-transparent text-start">
                                                <i data-lucide="log-out" style="width: 16px;"></i> Logout
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