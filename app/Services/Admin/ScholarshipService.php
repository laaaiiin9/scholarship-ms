<?php

namespace App\Services\Admin;

use App\Models\Scholarship;

class ScholarshipService
{

    public function store(array $data)
    {
        $scholarship = Scholarship::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'max_amount' => $data['max_amount'],
            'created_by' => auth()->user()->username
        ]);

        return $scholarship;
    }

    public function update(array $data, Scholarship $scholarship)
    {
        $scholarship->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'max_amount' => $data['max_amount'],
        ]);

        return $scholarship;
    }

}
