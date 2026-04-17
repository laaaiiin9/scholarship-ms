<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApplicationPeriodRequest;
use App\Models\ApplicationPeriod;
use App\Models\Scholarship;
use App\Services\Admin\ApplicationPeriodService;
use Illuminate\Http\Request;

class ApplicationPeriodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationPeriod::with('scholarship')->latest();
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('scholarship', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhere('status', 'like', '%' . $search . '%');
            }
            
            $periods = $query->paginate(10);
            return response()->json($periods);
        }

        $scholarships = Scholarship::orderBy('name')->get();
        return view('admin.application_periods', compact('scholarships'));
    }

    public function store(ApplicationPeriodRequest $request, ApplicationPeriodService $service)
    {
        $service->store($request->validated());

        return response()->json([
            'msg' => 'Application Period created successfully'
        ]);
    }

    public function edit(ApplicationPeriod $applicationPeriod)
    {
        return response()->json($applicationPeriod);
    }

    public function update(ApplicationPeriodRequest $request, ApplicationPeriodService $service, ApplicationPeriod $applicationPeriod)
    {
        $service->update($request->validated(), $applicationPeriod);

        return response()->json([
            'msg' => 'Application Period updated successfully'
        ]);
    }

    public function destroy(ApplicationPeriod $applicationPeriod)
    {
        $applicationPeriod->delete();

        return response()->json([
            'msg' => 'Application Period deleted successfully'
        ]);
    }
}
