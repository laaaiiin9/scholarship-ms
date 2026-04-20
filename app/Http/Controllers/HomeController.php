<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\User;
use App\Models\Application;
use App\Models\Decision;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $stats = [
            'scholarships' => Scholarship::count(),
            'students' => User::whereHas('roles', function($q) {
                $q->where('name', 'STUDENT');
            })->count(),
            'applications' => Application::where('status', '!=', Application::STATUS_DRAFT)->count(),
            'approved' => Decision::where('result', Decision::RESULT_APPROVED)->count(),
        ];

        return view('home', compact('stats'));
    }
}
