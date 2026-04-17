<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ApplyScholarshipRequest;
use App\Models\Application;
use App\Models\Scholarship;
use App\Services\Student\ScholarshipService;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $userId = auth()->id();

            $query = Scholarship::with([
                'requirements',
                'applicationPeriods' => function($q) {
                    $q->where('status', 'OPEN');
                }
            ])->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            }
            
            // Map the data for client-side evaluation
            $paginator = $query->paginate(6);
            
            // Pre-fetch all user applications to this batch of scholarships avoiding N+1 if logged in
            $appliedScholarshipIds = [];
            if ($userId) {
                $appliedScholarshipIds = Application::where('user_id', $userId)
                    ->pluck('scholarship_id')
                    ->toArray();
            }

            $paginator->getCollection()->transform(function ($scholarship) use ($appliedScholarshipIds) {
                $scholarship->has_open_period = $scholarship->applicationPeriods->isNotEmpty();
                $scholarship->has_applied = in_array($scholarship->id, $appliedScholarshipIds);
                return $scholarship;
            });

            return response()->json($paginator);
        }

        return view('student.scholarships');
    }

    public function apply(ApplyScholarshipRequest $request, ScholarshipService $service) {
        try {
            $service->apply($request->scholarship_id, auth()->id());
            return response()->json([
                'msg' => 'Application submitted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
