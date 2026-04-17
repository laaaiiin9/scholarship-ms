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
        $eligibleApplications = $service->getEligibleScholarships(auth()->id());
        
        return view('student.renewals.index', compact('eligibleApplications'));
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
        $data = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'renewal_period_id' => 'required|exists:renewal_periods,id',
        ]);

        // Security check
        $application = Application::findOrFail($data['application_id']);
        if ($application->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $service->submitRenewal($data, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Renewal request submitted successfully!',
            'redirect' => route('student.applications.index')
        ]);
    }
}
