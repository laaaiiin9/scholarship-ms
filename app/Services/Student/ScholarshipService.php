<?php

namespace App\Services\Student;

use App\Models\Application;
use App\Models\Scholarship;

class ScholarshipService
{
    public function apply(int $scholarshipId, int $userId)
    {
        $scholarship = Scholarship::with(['applicationPeriods' => function($q) {
            $q->where('status', 'OPEN')->latest();
        }])->findOrFail($scholarshipId);

        $activePeriod = $scholarship->applicationPeriods->first();

        if (!$activePeriod) {
            throw new \Exception('No active application period found for this scholarship.');
        }

        // Check if already applied
        $exists = Application::where('user_id', $userId)
            ->where('scholarship_id', $scholarshipId)
            ->exists();

        if ($exists) {
            throw new \Exception('You have already applied for this scholarship.');
        }

        return Application::create([
            'user_id' => $userId,
            'scholarship_id' => $scholarshipId,
            'application_period_id' => $activePeriod->id,
            'status' => Application::STATUS_DRAFT,
        ]);
    }
}
