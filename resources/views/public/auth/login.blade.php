@extends ('layouts.main')
@section('title', 'Login')

@section('content')
    <section class="register-section py-5 py-lg-6">
        <div class="container">
            <div class="register-shell">
                <div class="register-card h-100">
                    <div class="register-card-header">
                        <div>
                            <p class="eyebrow mb-1">User Login</p>
                            <h2>Welcome back</h2>
                        </div>
                        <span class="status-pill">Secure Access</span>
                    </div>

                    <form id="loginForm" action="#" method="POST" novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label register-label" for="login_email">Email</label>
                                <input class="form-control register-input" id="login_email" name="email"
                                    type="email" placeholder="Aria@gmail.com">
                            </div>

                            <div class="col-12">
                                <label class="form-label register-label" for="login_password">Password</label>
                                <input class="form-control register-input" id="login_password" name="password"
                                    type="password" placeholder="Enter your password">
                            </div>

                            <div class="col-12">
                                <label class="register-check">
                                    <input type="checkbox" name="remember" value="1">
                                    <span>Keep me signed in on this device.</span>
                                </label>
                            </div>
                        </div>

                        <div class="register-actions">
                            <button class="btn btn-custom-primary text-white" type="submit">Log In</button>
                            <a class="register-login-link" href="{{ route('auth.register') }}">No account yet? Create one</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
