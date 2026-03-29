<?php

namespace App\Services;

use App\Models\User;

class RegisterService {

    public function store($data = []) {
        return User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

}
