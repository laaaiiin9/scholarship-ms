@extends('layouts.main')
@section('title', 'Scholarships')

@section('content')
    <div class="row g-4" id="grid_scholarships">

    </div>

    <div class="row g-2 justify-content-center align-items-center my-3">
        <div class="col-auto">
            <div class="btn btn-secondary" id="prevBtn">Previous</div>
        </div>
        <div class="col-auto">
            <div class="btn btn-success" id="nextBtn">Next</div>
        </div>

    </div>
@endsection