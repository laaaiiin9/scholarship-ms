<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Decision;
use App\Models\Review;
use App\Mail\ApplicationStatusUpdated;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Application::with(['user.profile', 'scholarship'])
                ->orderBy('created_at', 'desc');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('scholarship_id')) {
                $query->where('scholarship_id', $request->scholarship_id);
            }

            return response()->json($query->paginate(10));
        }

        $scholarships = \App\Models\Scholarship::all();
        return view('admin.applications.index', compact('scholarships'));
    }

    public function show(Application $application)
    {
        $application->load(['user.profile', 'scholarship', 'documents.requirement', 'decision.decider', 'reviews.reviewer']);
        
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|string|in:UNDER_REVIEW,DECIDED,REVISION_REQUIRED',
            'result' => 'required_if:status,DECIDED|nullable|string|in:APPROVED,REJECTED,WAITLISTED',
            'remarks' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $application->status = $request->status;
            $application->save();

            if ($request->status === Application::STATUS_DECIDED) {
                Decision::updateOrCreate(
                    ['application_id' => $application->id],
                    [
                        'decided_by' => auth()->id(),
                        'result' => $request->result,
                    ]
                );

                // Auto-create disbursement if approved
                if ($request->result === Decision::RESULT_APPROVED) {
                    \App\Models\Disbursement::updateOrCreate(
                        ['application_id' => $application->id, 'renewal_id' => null],
                        ['amount' => 0, 'status' => 'PENDING']
                    );
                }
            }

            if ($request->filled('remarks')) {
                Review::create([
                    'application_id' => $application->id,
                    'reviewed_by' => auth()->id(),
                    'remarks' => $request->remarks,
                ]);
            }

            DB::commit();

            // Notify Student via Email
            $application->load('user', 'scholarship');
            //Mail::to($application->user->email)->send(new ApplicationStatusUpdated($application));

            // Notify Student on Dashboard
            $statusLabel = str_replace('_', ' ', $request->status);
            $resultLabel = $request->result ? " — Result: {$request->result}" : '';
            NotificationService::notifyStudent(
                $application->user_id,
                'Scholarship Application Update',
                "Your application for {$application->scholarship->name} has been updated to: {$statusLabel}{$resultLabel}.",
                'ALERT'
            );

            return response()->json([
                'success' => true,
                'message' => 'Application status updated successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update application status: ' . $e->getMessage()
            ], 500);
        }
    }
}
