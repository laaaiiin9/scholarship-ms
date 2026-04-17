<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Disbursement;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::all();
        return view('admin.reports.index', compact('scholarships'));
    }

    public function exportApplications(Request $request)
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=applications_report_' . now()->format('Y-m-d') . '.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $query = Application::with(['user.profile', 'scholarship', 'decision']);

        if ($request->filled('scholarship_id')) {
            $query->where('scholarship_id', $request->scholarship_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $callback = function() use ($query) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Student Name', 'Email', 'Scholarship', 'Status', 'Applied On', 'Decision Result']);

            $query->chunk(100, function($applications) use ($file) {
                foreach ($applications as $app) {
                    $profile = $app->user->profile;
                    fputcsv($file, [
                        $app->id,
                        ($profile->first_name ?? '') . ' ' . ($profile->last_name ?? ''),
                        $app->user->email,
                        $app->scholarship->name,
                        $app->status,
                        $app->created_at->toDateTimeString(),
                        $app->decision->result ?? 'N/A'
                    ]);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportDisbursements(Request $request)
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=disbursements_report_' . now()->format('Y-m-d') . '.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $query = Disbursement::with(['application.user.profile', 'application.scholarship']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $callback = function() use ($query) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Reference', 'Student Name', 'Scholarship', 'Amount', 'Status', 'Payout Date']);

            $query->chunk(100, function($disbursements) use ($file) {
                foreach ($disbursements as $d) {
                    $profile = $d->application->user->profile;
                    fputcsv($file, [
                        $d->id,
                        $d->renewal_id ? "Renewal #{$d->renewal_id}" : "Initial #{$d->application_id}",
                        ($profile->first_name ?? '') . ' ' . ($profile->last_name ?? ''),
                        $d->application->scholarship->name,
                        $d->amount,
                        $d->status,
                        $d->payout_date ?? 'N/A'
                    ]);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
