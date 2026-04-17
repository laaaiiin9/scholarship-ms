<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
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

            $studentRoleId = Role::query()
                ->where('name', Role::STUDENT)
                ->value('id');

            if ($studentRoleId) {
                $user->roles()->attach($studentRoleId);
            }

            event(new Registered($user));

            return $user;
        });
    }

}
