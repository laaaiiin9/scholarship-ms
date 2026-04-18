<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        $totalApplications = Application::where('user_id', $userId)->count();
        $approvedApplications = Application::where('user_id', $userId)
            ->where('status', Application::STATUS_DECIDED)
            ->count();
            
        $pendingApplications = Application::where('user_id', $userId)
            ->whereIn('status', [Application::STATUS_DRAFT, Application::STATUS_SUBMITTED, Application::STATUS_UNDER_REVIEW])
            ->count();

        // Financials
        $totalReceived = \App\Models\Disbursement::whereHas('application', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', 'PAID')
            ->sum('amount');

        $activeApplications = Application::with(['scholarship'])
            ->where('user_id', $userId)
            ->where('status', '!=', Application::STATUS_DRAFT)
            ->latest()
            ->take(5)
            ->get();

        // Recent Notifications
        $recentNotifications = \App\Models\Notification::where(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereNull('user_id');
            })
            ->latest()
            ->take(3)
            ->get();

        $statusCounts = Application::where('user_id', $userId)
            ->select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('student.dashboard', compact(
            'totalApplications',
            'approvedApplications',
            'pendingApplications',
            'totalReceived',
            'activeApplications',
            'recentNotifications',
            'statusCounts'
        ));
    }
}
