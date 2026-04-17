<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RequirementRequest;
use App\Models\Requirement;
use App\Models\Scholarship;
use App\Services\Admin\RequirementService;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $query = Requirement::with('scholarship')->latest();
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhereHas('scholarship', function($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            }
            
            // Allow filtering by specific scholarship if needed
            if ($request->filled('scholarship_id')) {
                $query->where('scholarship_id', $request->scholarship_id);
            }
            
            $requirements = $query->paginate(5);
            return response()->json($requirements);
        }
        
        $scholarships = Scholarship::orderBy('name', 'asc')->get();
        return view('admin.requirements', compact('scholarships'));
    }

    public function store(RequirementRequest $request, RequirementService $service) {
        $service->store($request->validated());

        return response()->json([
            'msg' => 'Requirement created successfully'
        ]);
    }

    public function edit(Requirement $requirement) {
        return response()->json($requirement);
    }

    public function update(RequirementRequest $request, RequirementService $service, Requirement $requirement) {
        $service->update($request->validated(), $requirement);

        return response()->json([
            'msg' => 'Requirement updated successfully'
        ]);
    }

    public function destroy(Requirement $requirement) {
        $requirement->delete();

        return response()->json([
            'msg' => 'Requirement deleted successfully'
        ]);
    }
}
