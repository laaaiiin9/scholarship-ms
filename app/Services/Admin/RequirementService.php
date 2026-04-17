<?php

namespace App\Services\Admin;

use App\Models\Requirement;

class RequirementService
{
    public function store(array $data)
    {
        return Requirement::create([
            'name' => $data['name'],
            'scholarship_id' => $data['scholarship_id'],
            'type' => $data['type']
        ]);
    }

    public function update(array $data, Requirement $requirement)
    {
        $requirement->update([
            'name' => $data['name'],
            'scholarship_id' => $data['scholarship_id'],
            'type' => $data['type']
        ]);

        return $requirement;
    }
}
