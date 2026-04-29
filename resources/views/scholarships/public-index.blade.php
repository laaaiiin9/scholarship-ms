@extends('layouts.main')
@section('title', 'Scholarship Programs')

@section('content')
<section class="py-5 bg-light-subtle min-vh-100">
    <div class="container py-lg-5">
        <div class="text-center mb-5 scroll-animate">
            <h1 class="fw-bold display-4 mb-3">Available Scholarships</h1>
            <p class="text-secondary mx-auto" style="max-width: 600px;">
                Explore various opportunities designed to support your academic journey. Start your application today.
            </p>
        </div>

        <div class="row g-4" id="public-scholarships-container" 
             data-auth="{{ auth()->check() ? 'true' : 'false' }}"
             data-register-url="{{ route('auth.register') }}"
             data-student-url="{{ route('student.scholarships') }}">
            <!-- Content loaded via JS -->
        </div>
    </div>
</section>
@endsection