<?php

namespace App\Services\Admin;

use App\Models\ApplicationPeriod;

class ApplicationPeriodService
{
    public function store(array $data)
    {
        return ApplicationPeriod::create([
            'scholarship_id' => $data['scholarship_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']
        ]);
    }

    public function update(array $data, ApplicationPeriod $applicationPeriod)
    {
        $applicationPeriod->update([
            'scholarship_id' => $data['scholarship_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']
        ]);

        return $applicationPeriod;
    }
}
