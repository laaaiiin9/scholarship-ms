<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/signIn', [AuthController::class, 'authenticate'])->name('auth.signin');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/signUp', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

/* Email Verification */
Route::middleware(['auth'])->prefix('email')->group(function () {
    Route::get('verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
    Route::post('verify/notification', [VerificationController::class, 'sendEmail'])->middleware(['throttle:6,1'])->name('verification.send');
});
/* End Email Verification */

/* Student */
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
/* End Student */

/* Admin */
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('scholarships', [ScholarshipController::class, 'index'])->name('scholarships');
    Route::get('requirements', [RequirementController::class, 'index'])->name('requirements');
    Route::post('requirements/store', [RequirementController::class, 'store'])->name('requirements.store');
    Route::get('requirements/{requirement}/edit', [RequirementController::class, 'edit'])->name('requirements.edit');
    Route::put('requirements/{requirement}', [RequirementController::class, 'update'])->name('requirements.update');
    Route::delete('requirements/{requirement}', [RequirementController::class, 'destroy'])->name('requirements.destroy');
    Route::post('scholarships/store', [ScholarshipController::class, 'store'])->name('scholarships.store');
    Route::get('scholarships/{scholarship}/edit', [ScholarshipController::class, 'edit'])->name('scholarships.edit');
    Route::put('scholarships/{scholarship}', [ScholarshipController::class, 'update'])->name('scholarships.update');
    Route::delete('scholarships/{scholarship}', [ScholarshipController::class, 'destroy'])->name('scholarships.destroy');

    Route::get('application-periods', [\App\Http\Controllers\Admin\ApplicationPeriodController::class, 'index'])->name('application-periods');
    Route::post('application-periods/store', [\App\Http\Controllers\Admin\ApplicationPeriodController::class, 'store'])->name('application-periods.store');
    Route::get('application-periods/{applicationPeriod}/edit', [\App\Http\Controllers\Admin\ApplicationPeriodController::class, 'edit'])->name('application-periods.edit');
    Route::put('application-periods/{applicationPeriod}', [\App\Http\Controllers\Admin\ApplicationPeriodController::class, 'update'])->name('application-periods.update');
    Route::delete('application-periods/{applicationPeriod}', [\App\Http\Controllers\Admin\ApplicationPeriodController::class, 'destroy'])->name('application-periods.destroy');
});
/* End Admin */