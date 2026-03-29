<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;

class AuthController extends Controller
{
    public function login() {
        return view('public.auth.login');
    }

    public function register() {
        return view('public.auth.register');
    }

    public function signUp(RegisterRequest $request, RegisterService $service) {
        $service->store($request->validated());

        return response()->json([
            'ok' => true,
            'msg' => 'Registration successful'
        ], 201);
    }

    
}
