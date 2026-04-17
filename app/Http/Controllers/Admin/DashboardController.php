<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        // Basic Stats
        $totalApplications = Application::count();
        $forReviewCount = Application::whereIn('status', [Application::STATUS_SUBMITTED, Application::STATUS_UNDER_REVIEW])->count();
        $approvedCount = Application::whereHas('decision', function($q) {
            $q->where('result', \App\Models\Decision::RESULT_APPROVED);
        })->count();
        $rejectedCount = Application::whereHas('decision', function($q) {
            $q->where('result', \App\Models\Decision::RESULT_REJECTED);
        })->count();

        // Financial Metrics
        $totalReleased = \App\Models\Disbursement::where('status', 'PAID')->sum('amount');
        $potentialFunds = \App\Models\Disbursement::where('status', 'PENDING')->sum('amount');

        // Application Trends (Last 6 Months)
        $months = [];
        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M');
            $trendData[] = Application::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        // Scholarship Distribution
        $scholarshipStats = \App\Models\Scholarship::withCount('applications')
            ->get()
            ->map(function($s) {
                return [
                    'name' => $s->name,
                    'count' => $s->applications_count
                ];
            });

        $recentApplications = Application::with(['scholarship', 'user.profile'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalApplications', 
            'forReviewCount', 
            'approvedCount', 
            'rejectedCount',
            'totalReleased',
            'potentialFunds',
            'months',
            'trendData',
            'scholarshipStats',
            'recentApplications'
        ));
    }
}
