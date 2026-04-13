<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            /* inserts student role for new users */
            $user->roles()->attach(2);

            event(new Registered($user));

            return $user;
        });
    }

}
