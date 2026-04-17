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
                    $q->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('profile', function($pq) use ($search) {
                          $pq->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->filled('id')) {
                $query->where('id', $request->id);
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
        $disbursement->load('application.scholarship');
        $maxAmount = $disbursement->application->scholarship->max_amount;

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($maxAmount) {
                    if ($maxAmount > 0 && $value > $maxAmount) {
                        $fail("The amount cannot exceed the scholarship's maximum allowance of ₱" . number_format($maxAmount, 2));
                    }
                },
            ],
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
