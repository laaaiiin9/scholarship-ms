<?php

namespace App\Services\Admin;

use App\Models\RenewalPeriod;

class RenewalPeriodService
{
    public function store(array $data)
    {
        return RenewalPeriod::create([
            'scholarship_id' => $data['scholarship_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']
        ]);
    }

    public function update(array $data, RenewalPeriod $renewalPeriod)
    {
        $renewalPeriod->update([
            'scholarship_id' => $data['scholarship_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']
        ]);

        return $renewalPeriod;
    }
}
