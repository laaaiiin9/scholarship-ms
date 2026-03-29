<?php

namespace App\Services\Student;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function createOrSave($data = [])
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        if ($profile) {
            $profile->update($data);

            return [
                'type' => 'update',
                'data' => $profile->fresh()
            ];
        }

        $profile = Profile::create([
            ...$data,
            'user_id' => Auth::id(),
        ]);

        return [
            'type' => 'create',
            'data' => $profile
        ];
    }

}
