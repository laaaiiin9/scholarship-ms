<?php

namespace App\Services\Student;

use App\Models\Application;
use App\Models\Scholarship;
use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\Storage;

class ApplicationService
{
    /**
     * Parse and submit the fully constructed Application.
     */
    public function submitApplication(array $data, int $userId)
    {
        $scholarshipId = $data['scholarship_id'];

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

        // Create the core Application model
        $application = Application::create([
            'user_id' => $userId,
            'scholarship_id' => $scholarshipId,
            'application_period_id' => $activePeriod->id,
            'status' => Application::STATUS_SUBMITTED, // Immediate submission mode
        ]);

        // Process uploaded requirement files
        if (isset($data['requirements']) && is_array($data['requirements'])) {
            foreach ($data['requirements'] as $requirementId => $file) {
                // Determine a safe unique path inside storage
                $path = $file->store('applications/' . $application->id, 'public');

                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'requirement_id' => $requirementId,
                    'file_path' => $path,
                    'verification_status' => ApplicationDocument::STATUS_PENDING,
                ]);
            }
        }

        return $application;
    }
}
