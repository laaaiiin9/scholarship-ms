<header class="sticky-top">
    <nav class="navbar navbar-expand-lg bg-body-transparent">
        <div class="container-fluid mx-0 mx-sm-5">

            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="Bootstrap" height="40">
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
                                <a class="btn-bordered d-block text-center d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="text-decoration: none;">
                                    <span>{{ auth()->user()->username }}</span>
                                    <svg class="chevron-icon chevron-down" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                    <svg class="chevron-icon chevron-up" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                                        <polyline points="18 15 12 9 6 15"></polyline>
                                    </svg>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('student.profile') }}">Profile</a></li>
                                    @if(auth()->user()->hasRole('admin'))
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                    @elseif(auth()->user()->hasRole('student'))
                                    <li><a class="dropdown-item" href="">Dashboard</a></li>
                                    @else
                                    @endif
                                    
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form data-ajax-form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
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