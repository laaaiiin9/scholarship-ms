<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $user = auth()->user();

            if (!$user->is_active) {
                Auth::logout();
                return response()->json([
                    'errors' => [
                        'email' => ['Your account has been deactivated. Please contact support.']
                    ]
                ], 423); // 423 Locked
            }

            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login successful',
                'redirect' => $user->hasVerifiedEmail() ? route('home') : route('verification.notice'),
            ]);
        }

        return response()->json([
            'errors' => [
                'email' => ['Invalid credentials']
            ]
        ], 422);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function signUp(RegisterRequest $request, RegisterService $service)
    {
        $service->store($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Registered successfully',
            'redirect' => route('auth.login')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logout successful',
            'redirect' => route('auth.login'),
        ]);
    }

}
