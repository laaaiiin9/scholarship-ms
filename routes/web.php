<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\Public\PublicPagesController;
use App\Http\Controllers\Student\ProfileController;
use Illuminate\Support\Facades\Route;

/* Auth */
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/signIn', [AuthController::class, 'signIn'])->name('auth.signIn');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/signUp', [AuthController::class, 'signUp'])->name('auth.signUp');
/* End Auth */

/* Email Verification */
Route::middleware(['auth'])->prefix('email')->group(function () {
    Route::get('verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
    Route::post('verify/notification', [VerificationController::class, 'sendEmail'])->middleware(['throttle:6,1'])->name('verification.send');
});
/* End Email Verification */

/* Student */
Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile', [ProfileController::class, 'createOrSave'])->name('profile.save');
});
/* End Student */

/* Public Pages */

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/scholarships', [PublicPagesController::class, 'scholarshipsPage'])->name('scholarships');
Route::get('/scholarships/list', [PublicPagesController::class, 'scholarships'])->name('scholarships.list');

/* End Public Pages */

/* Test */
Route::get('/test', function () {
    $start = microtime(true);

    \App\Models\Scholarship::paginate(6);

    return microtime(true) - $start;
});
