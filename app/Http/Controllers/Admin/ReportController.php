<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Decision;
use App\Models\Disbursement;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 1. High-level Summary Metrics
        $totalApps = Application::count();
        $totalDisbursed = Disbursement::where('status', Disbursement::STATUS_PAID)->sum('amount');
        
        $approvalRate = 0;
        if ($totalApps > 0) {
            $approved = Application::whereHas('decision', function($q) {
                $q->where('result', Decision::RESULT_APPROVED);
            })->count();
            $approvalRate = ($approved / $totalApps) * 100;
        }

        // 2. Outcome Distribution (for Pie Chart)
        $outcomes = [
            'Approved' => Application::whereHas('decision', function($q) { $q->where('result', Decision::RESULT_APPROVED); })->count(),
            'Rejected' => Application::whereHas('decision', function($q) { $q->where('result', Decision::RESULT_REJECTED); })->count(),
            'Waitlisted' => Application::whereHas('decision', function($q) { $q->where('result', Decision::RESULT_WAITLISTED); })->count(),
            'Pending' => Application::whereIn('status', [Application::STATUS_SUBMITTED, Application::STATUS_UNDER_REVIEW])->count(),
        ];

        // 3. Monthly Trends (last 6 months)
        $trendData = Application::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->take(6)
        ->get()
        ->reverse()
        ->values();

        return view('admin.reports.index', compact(
            'totalApps', 
            'totalDisbursed', 
            'approvalRate', 
            'outcomes', 
            'trendData'
        ));
    }

    public function applications(Request $request)
    {
        $scholarships = Scholarship::all();
        
        $query = Application::with(['scholarship', 'user.profile', 'decision'])
            ->latest();

        // Filtering
        if ($request->filled('scholarship_id')) {
            $query->where('scholarship_id', $request->scholarship_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($pq) use ($search) {
                      $pq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->wantsJson()) {
            return response()->json($query->paginate(10));
        }

        return view('admin.reports.applications', compact('scholarships'));
    }

    public function exportApplications(Request $request)
    {
        $query = Application::with(['scholarship', 'user.profile', 'decision']);

        if ($request->filled('scholarship_id')) {
            $query->where('scholarship_id', $request->scholarship_id);
        }

        $applications = $query->get();

        $filename = "applications_report_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Headers
        fputcsv($handle, ['Applicant Name', 'Email', 'Scholarship', 'Applied On', 'Status', 'Decision']);

        foreach ($applications as $app) {
            $fullName = $app->user->profile 
                ? $app->user->profile->first_name . ' ' . $app->user->profile->last_name 
                : $app->user->name;

            fputcsv($handle, [
                $fullName,
                $app->user->email,
                $app->scholarship->name,
                $app->created_at->format('Y-m-d'),
                $app->status,
                $app->decision->result ?? 'N/A'
            ]);
        }

        fclose($handle);
        return exit;
    }
}
