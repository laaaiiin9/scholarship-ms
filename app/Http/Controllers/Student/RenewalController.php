<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\RenewalPeriod;
use App\Models\Application;
use App\Services\Student\RenewalService;
use Illuminate\Http\Request;

class RenewalController extends Controller
{
    public function index(RenewalService $service)
    {
        $userId = auth()->id();
        $eligibleApplications = $service->getEligibleScholarships($userId);
        $renewalHistory = \App\Models\Renewal::where('user_id', $userId)
            ->with(['scholarship', 'application'])
            ->latest()
            ->get();
        
        return view('student.renewals.index', compact('eligibleApplications', 'renewalHistory'));
    }

    public function create(Application $application)
    {
        // Security check
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $scholarship = $application->scholarship;
        $activeRenewalPeriod = $scholarship->renewalPeriods()->where('status', 'OPEN')->first();

        if (!$activeRenewalPeriod) {
            return redirect()->route('student.renewals.index')->with('error', 'No active renewal period found for this scholarship.');
        }

        return view('student.renewals.create', compact('application', 'scholarship', 'activeRenewalPeriod'));
    }

    public function store(Request $request, RenewalService $service)
    {
        try {
            $request->validate([
                'application_id'    => 'required|exists:applications,id',
                'renewal_period_id' => 'required|exists:renewal_periods,id',
            ]);

            // Security check
            $application = Application::findOrFail($request->input('application_id'));
            if ($application->user_id !== auth()->id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // ---------------------------------------------------------------------------
            // File Extraction — handles both correctly-parsed PHP arrays AND literal
            // bracket-notation keys (e.g. 'requirements[3]') that can occur with
            // some JS FormData implementations.
            // ---------------------------------------------------------------------------
            $reqFiles = $request->file('requirements') ?? [];

            if (empty($reqFiles)) {
                foreach ($request->allFiles() as $key => $file) {
                    if (preg_match('/^requirements\[(\d+)\]$/', $key, $matches)) {
                        $reqFiles[(int)$matches[1]] = $file;
                    }
                }
            }

            $service->submitRenewal(
                applicationId:   (int) $request->input('application_id'),
                renewalPeriodId: (int) $request->input('renewal_period_id'),
                userId:          auth()->id(),
                requirementFiles: $reqFiles
            );

            return response()->json([
                'success'  => true,
                'message'  => 'Renewal submitted successfully!',
                'redirect' => route('student.renewals.index'),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('RenewalController@store: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Failed to submit renewal: ' . $e->getMessage()], 500);
        }
    }
}
