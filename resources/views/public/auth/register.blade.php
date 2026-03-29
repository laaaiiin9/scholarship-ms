@extends ('layouts.main')
@section('title', 'Register')

@section('content')
    <section class="register-section py-5 py-lg-6">
        <div class="container">

            <div class="register-shell">
                <div class="register-card h-100">
                    <div class="register-card-header">
                        <div>
                            <p class="eyebrow mb-1">User Registration</p>
                            <h2>Create an account</h2>
                        </div>
                        <span class="status-pill">Step 1 of 1</span>
                    </div>

                    <form id="registerForm" action="{{ route('auth.signUp') }}" method="POST" novalidate>
                        @csrf

                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label register-label" for="username">Username</label>
                                <input class="form-control register-input" id="username" name="username" type="text"
                                    placeholder="Aria">
                            </div>

                            <div class="col-12">
                                <label class="form-label register-label" for="email">Email</label>
                                <input class="form-control register-input" id="email" name="email" type="email"
                                    placeholder="Aria@gmail.com">
                            </div>

                            <div class="col-12">
                                <label class="form-label register-label" for="password">Password</label>
                                <input class="form-control register-input" id="password" name="password" type="password"
                                    placeholder="Create a password">
                            </div>

                            <div class="col-12">
                                <label class="form-label register-label" for="password_confirmation">Confirm
                                    Password</label>
                                <input class="form-control register-input" id="password_confirmation"
                                    name="password_confirmation" type="password" placeholder="Confirm your password">
                            </div>

                            <div class="col-12">
                                <label class="register-check">
                                    <input type="checkbox" name="terms" value="1">
                                    <span>I agree to the terms, privacy policy, and scholarship application
                                        guidelines.</span>
                                </label>
                            </div>
                        </div>

                        <div class="register-actions">
                            <button class="btn btn-custom-primary text-white" type="submit">Create Account</button>
                            <a class="register-login-link" href="{{ route('auth.login') }}">Already have an account? Log in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
