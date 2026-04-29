<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipPublicController extends Controller
{
    public function index()
    {
        return view('scholarships.public-index');
    }

    public function apiIndex()
    {
        $scholarships = Scholarship::orderBy('name')->get();
        return response()->json($scholarships);
    }
}
