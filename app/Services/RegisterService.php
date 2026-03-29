<?php

namespace App\Services;

use App\Models\User;

class RegisterService {

    public function store($data = []) {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

}
