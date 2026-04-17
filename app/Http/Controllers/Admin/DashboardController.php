<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $totalApplications = Application::count();
        $forReviewCount = Application::whereIn('status', [Application::STATUS_SUBMITTED, Application::STATUS_UNDER_REVIEW])->count();
        $approvedCount = Application::whereHas('decision', function($q) {
            $q->where('result', \App\Models\Decision::RESULT_APPROVED);
        })->count();
        $rejectedCount = Application::whereHas('decision', function($q) {
            $q->where('result', \App\Models\Decision::RESULT_REJECTED);
        })->count();

        return view('admin.dashboard', compact('totalApplications', 'forReviewCount', 'approvedCount', 'rejectedCount'));
    }
}
