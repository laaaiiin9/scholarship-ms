<?php

namespace App\Services\Student;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileUpdateService
{

    public function update(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'contact_number' => $data['contact_number'] ?? null,
                    'address' => $data['address'] ?? null,
                    'birth_date' => $data['birth_date'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'school' => $data['school'],
                    'course' => $data['course'],
                ]
            );

            return $user->fresh('profile');
        });
    }

}
