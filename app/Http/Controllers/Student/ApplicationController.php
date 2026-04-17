<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\Application;
use App\Http\Requests\Student\StoreApplicationRequest;
use App\Services\Student\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the student's applications.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Application::with(['scholarship'])
                ->where('user_id', auth()->id())
                ->latest();

            return response()->json($query->paginate(10));
        }

        return view('student.applications.index');
    }

    /**
     * Display the specific tracking details of an application.
     */
    public function show(Application $application)
    {
        // Security check
        if ($application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to application.');
        }

        $application->load(['scholarship', 'applicationPeriod', 'documents.requirement', 'decision.decider']);
        
        return view('student.applications.show', compact('application'));
    }

    /**
     * Display the application form for a specific scholarship.
     */
    public function create(Scholarship $scholarship)
    {
        $userId = auth()->id();

        // Validate active period
        $activePeriod = $scholarship->applicationPeriods()->where('status', 'OPEN')->first();
        if (!$activePeriod) {
            return redirect()->route('student.scholarships')->with('error', 'This scholarship does not have an active application period.');
        }

        // Validate if already applied
        $exists = Application::where('user_id', $userId)
            ->where('scholarship_id', $scholarship->id)
            ->exists();
            
        if ($exists) {
            return redirect()->route('student.scholarships')->with('error', 'You have already applied for this scholarship.');
        }

        // Load requirements for the view
        $scholarship->load('requirements');

        return view('student.applications.create', compact('scholarship', 'activePeriod'));
    }

    /**
     * Store the submitted application form natively.
     */
    public function store(StoreApplicationRequest $request, ApplicationService $service)
    {
        try {
            $data = $request->validated();
            // Assign the raw uploaded files from request exactly as validated
            $data['requirements'] = $request->file('requirements', []);
            
            $service->submitApplication($data, auth()->id());
            
            return response()->json([
                'msg' => 'Application submitted successfully with all documents!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
