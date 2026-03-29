<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\RegisterService;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('public.auth.login');
    }

    public function signIn(LoginRequest $request) {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return response()->json([
                'msg' => 'Login successful',
                'redirect' => route('home'),
            ]);
        }

        return response()->json([
            'errors' => [
                'email' => ['Invalid credentials']
            ]
        ], 422);
    }

    public function register() {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('public.auth.register');
    }

    public function signUp(RegisterRequest $request, RegisterService $service) {
        $service->store($request->validated());

        return response()->json([
            'ok' => true,
            'msg' => 'Registration successful',
            'redirect' => route('auth.login'),
        ], 201);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'msg' => 'Logout successful',
            'redirect' => route('auth.login'),
        ]);
    }
    
}
