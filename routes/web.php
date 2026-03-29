<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
})->name('home');

/* Auth */
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/signIn', [AuthController::class, 'signIn'])->name('auth.signIn');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/signUp', [AuthController::class, 'signUp'])->name('auth.signUp');
/* End Auth */
