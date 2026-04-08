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
                    <a class="nav-link" href="{{ route('public.scholarships') }}">Scholarships</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#how-it-works">How It Works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#impact">Impact</a>
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
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @if (Auth::user()->hasRole('student'))
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}">Profile</a></li>
                        @else
                        @endif
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
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
