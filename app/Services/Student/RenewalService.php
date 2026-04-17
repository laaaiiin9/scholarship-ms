<?php

namespace App\Services\Student;

use App\Models\Application;
use App\Models\Renewal;
use App\Models\RenewalPeriod;
use Illuminate\Support\Facades\DB;

class RenewalService
{
    /**
     * Get scholarships where the student is eligible for renewal.
     */
    public function getEligibleScholarships(int $userId)
    {
        // Eligible means:
        // 1. Application status is APPROVED (via Decision)
        // 2. Scholarship has an OPEN RenewalPeriod
        // 3. User hasn't already submitted for this RenewalPeriod
        
        return Application::where('user_id', $userId)
            ->whereHas('decision', function($q) {
                $q->where('result', 'APPROVED');
            })
            ->whereHas('scholarship.renewalPeriods', function($q) {
                $q->where('status', 'OPEN');
            })
            ->with(['scholarship.renewalPeriods' => function($q) {
                $q->where('status', 'OPEN');
            }])
            ->get()
            ->filter(function($app) use ($userId) {
                $openPeriod = $app->scholarship->renewalPeriods->first();
                if (!$openPeriod) return false;
                
                // Check if already submitted for THIS period
                return !Renewal::where('user_id', $userId)
                    ->where('renewal_period_id', $openPeriod->id)
                    ->exists();
            });
    }

    public function submitRenewal(array $data, int $userId)
    {
        return DB::transaction(function() use ($data, $userId) {
            return Renewal::create([
                'application_id' => $data['application_id'],
                'renewal_period_id' => $data['renewal_period_id'],
                'user_id' => $userId,
                'status' => Renewal::STATUS_SUBMITTED
            ]);
        });
    }
}
