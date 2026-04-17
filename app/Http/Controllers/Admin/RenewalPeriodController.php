<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RenewalPeriodRequest;
use App\Models\RenewalPeriod;
use App\Models\Scholarship;
use App\Services\Admin\RenewalPeriodService;
use Illuminate\Http\Request;

class RenewalPeriodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = RenewalPeriod::with('scholarship')->latest();
            
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
        return view('admin.renewals.periods', compact('scholarships'));
    }

    public function store(RenewalPeriodRequest $request, RenewalPeriodService $service)
    {
        $service->store($request->validated());

        return response()->json([
            'msg' => 'Renewal Period created successfully'
        ]);
    }

    public function edit(RenewalPeriod $renewalPeriod)
    {
        return response()->json($renewalPeriod);
    }

    public function update(RenewalPeriodRequest $request, RenewalPeriodService $service, RenewalPeriod $renewalPeriod)
    {
        $service->update($request->validated(), $renewalPeriod);

        return response()->json([
            'msg' => 'Renewal Period updated successfully'
        ]);
    }

    public function destroy(RenewalPeriod $renewalPeriod)
    {
        $renewalPeriod->delete();

        return response()->json([
            'msg' => 'Renewal Period deleted successfully'
        ]);
    }
}
