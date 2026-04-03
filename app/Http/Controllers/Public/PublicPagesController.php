<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicPagesController extends Controller
{
    public function scholarships() {
        return view('public.scholarships');
    }

    

}
