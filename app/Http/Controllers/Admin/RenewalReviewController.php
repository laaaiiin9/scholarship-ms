<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renewal;
use App\Models\Disbursement;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RenewalReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Renewal::with(['user.profile', 'scholarship', 'application.user.profile', 'application.decision'])
                ->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('profile', function($pq) use ($search) {
                          $pq->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return response()->json($query->paginate(10));
        }

        return view('admin.renewals.index');
    }

    public function show(Renewal $renewal)
    {
        $renewal->load(['user.profile', 'scholarship', 'documents.requirement', 'application.user.profile', 'application.decision']);
        return response()->json($renewal);
    }

    public function update(Request $request, Renewal $renewal)
    {
        $request->validate([
            'status' => 'required|string|in:APPROVED,REJECTED,UNDER_REVIEW',
            'remarks' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $renewal->status = $request->status;
            $renewal->remarks = $request->remarks;
            $renewal->save();

            // Handle disbursement based on status
            if ($request->status === Renewal::STATUS_APPROVED) {
                Disbursement::updateOrCreate(
                    [
                        'application_id' => $renewal->application_id,
                        'renewal_id' => $renewal->id
                    ],
                    [
                        'amount' => 0, // Admin can set this later in Disbursement module
                        'status' => 'PENDING'
                    ]
                );
            } else {
                // If not approved, find any existing PENDING disbursement for this renewal and mark as CANCELLED
                Disbursement::where('renewal_id', $renewal->id)
                    ->where('status', 'PENDING')
                    ->update(['status' => 'CANCELLED']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Renewal status updated successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update renewal: ' . $e->getMessage()
            ], 500);
        }
    }
}
