<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalApplications = Application::where('user_id', $userId)->count();
        $approvedApplications = Application::where('user_id', $userId)
            ->where('status', Application::STATUS_DECIDED)
            ->count();
            
        $pendingApplications = Application::where('user_id', $userId)
            ->whereIn('status', [Application::STATUS_DRAFT, Application::STATUS_SUBMITTED, Application::STATUS_UNDER_REVIEW])
            ->count();

        $activeApplications = Application::with(['scholarship'])
            ->where('user_id', $userId)
            ->where('status', '!=', Application::STATUS_DRAFT)
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'totalApplications',
            'approvedApplications',
            'pendingApplications',
            'activeApplications'
        ));
    }
}
