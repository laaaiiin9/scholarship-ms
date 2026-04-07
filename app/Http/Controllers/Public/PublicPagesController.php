<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class PublicPagesController extends Controller
{
    public function scholarships() {
        return view('public.scholarships');
    }

    public function fetchScholarships() {
        $data = Scholarship::get();

        return response()->json([
            'data' => $data
        ]);
    }

}
