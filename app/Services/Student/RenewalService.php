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

    public function submitRenewal(int $applicationId, int $renewalPeriodId, int $userId, array $requirementFiles = [])
    {
        return DB::transaction(function () use ($applicationId, $renewalPeriodId, $userId, $requirementFiles) {

            $renewal = Renewal::create([
                'application_id'    => $applicationId,
                'renewal_period_id' => $renewalPeriodId,
                'user_id'           => $userId,
                'status'            => Renewal::STATUS_SUBMITTED,
            ]);

            foreach ($requirementFiles as $requirementId => $file) {
                if (!($file instanceof \Illuminate\Http\UploadedFile)) {
                    continue;
                }

                $path = $file->store("renewals/{$renewal->id}", 'public');

                \App\Models\ApplicationDocument::create([
                    'application_id'      => $renewal->application_id,
                    'requirement_id'      => (int) $requirementId,
                    'renewal_id'          => $renewal->id,
                    'file_path'           => $path,
                    'verification_status' => \App\Models\ApplicationDocument::STATUS_PENDING,
                    'type'                => \App\Models\ApplicationDocument::TYPE_RENEWAL,
                ]);
            }

            return $renewal;
        });
    }
}
