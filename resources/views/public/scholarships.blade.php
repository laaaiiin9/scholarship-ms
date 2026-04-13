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

            </div>

            <div class="d-flex justify-content-end align-items-center gap-2 mt-5">
                <button class="btn btn-light btn-hero-secondary" id="prevBtn">Previous</button>
                <p class="m-0">Page of 1/2</p>
                <button class="btn btn-light btn-hero-secondary" id="nextBtn">Next</button>
            </div>

        </div>
    </section>
@endsection