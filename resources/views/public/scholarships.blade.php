@extends('layouts.main')
@section('title', 'Scholarships')

@section('content')
    <section class="py-5 py-lg-6">
        <div class="container">

            <form action="" method="GET">
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label register-label app-form-label" for="first_name">Search Scholarship</label>
                        <input class="form-control register-input app-form-control" id="searchbar" name="searchbar"
                            type="text" placeholder="Scholarship Name">
                    </div>
                </div>
            </form>

            <div class="row g-2" id="scholarship-container">
            <!-- <div class="row g-2"> -->

                <!-- <div class="d-flex justify-content-center" id="data-spiner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div> -->
                
                <!-- <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card app-card app-card--interactive h-100 g-0">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div data-lucide="GraduationCap"></div>
                            </div>
                            <div class="col-auto">
                                <h5 class="m-0">$15,000</h5>
                            </div>
                        </div>

                        <h3 class="m-0">Test Title</h3>
                        <div class="app-card-copy-soft">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab et accusamus dolorum consectetur
                            molestias, minima corporis deserunt vitae asperiores quod eveniet, doloremque facilis odio.
                            Atque cupiditate magnam enim quis quae!
                        </div>

                        <div class="row">
                            <p><i data-lucide="Calendar1"></i> Deadline: Feb 9, 2026</p>
                            <p><i data-lucide="User"></i> Eligibility: SHS Graduate</p>
                        </div>

                        <div class="d-flex align-items-center">
                            <button class="btn btn-custom-primary text-white btn-cta">Apply Now</button>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="d-flex justify-content-end align-items-center gap-2 mt-5">
                <button disabled class="btn btn-light btn-hero-secondary" id="prevBtn">Previous</button>
                <p class="m-0"></p>
                <button disabled class="btn btn-light btn-hero-secondary" id="nextBtn">Next</button>
            </div>

        </div>
    </section>
@endsection