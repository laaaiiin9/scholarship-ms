<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Decision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $application->load(['user.profile', 'scholarship', 'documents.requirement', 'decision.decider']);
        
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
                        // If remarks module exists in db: 'remarks' => $request->remarks
                    ]
                );
            }

            DB::commit();

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
