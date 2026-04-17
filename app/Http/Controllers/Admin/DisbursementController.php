<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disbursement;
use Illuminate\Http\Request;

class DisbursementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Disbursement::with(['application.user.profile', 'application.scholarship', 'renewal'])
                ->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('application.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return response()->json($query->paginate(10));
        }

        return view('admin.disbursements.index');
    }

    public function update(Request $request, Disbursement $disbursement)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:PENDING,PAID,CANCELLED',
            'payout_date' => 'required_if:status,PAID|nullable|date',
        ]);

        $disbursement->update([
            'amount' => $request->amount,
            'status' => $request->status,
            'payout_date' => $request->status === 'PAID' ? $request->payout_date : $disbursement->payout_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Disbursement record updated successfully.'
        ]);
    }
}
