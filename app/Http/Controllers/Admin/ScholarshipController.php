<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScholarshipRequest;
use App\Models\Scholarship;
use App\Services\Admin\ScholarshipService;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $query = Scholarship::latest();
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            }
            
            $scholarships = $query->paginate(5);
            return response()->json($scholarships);
        }
        return view('admin.scholarships');
    }

    public function store(ScholarshipRequest $request, ScholarshipService $service) {
        $service->store($request->validated());

        return response()->json([
            'msg' => 'Scholarship created successfully'
        ]);
    }

    public function edit(Scholarship $scholarship) {
        return response()->json($scholarship);
    }

    public function update(ScholarshipRequest $request, ScholarshipService $service, Scholarship $scholarship) {
        $service->update($request->validated(), $scholarship);

        return response()->json([
            'msg' => 'Scholarship updated successfully'
        ]);
    }

    public function destroy(Scholarship $scholarship) {
        $scholarship->delete();

        return response()->json([
            'msg' => 'Scholarship deleted successfully'
        ]);
    }

}
