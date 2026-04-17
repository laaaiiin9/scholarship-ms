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
// Authenticated Student Routes
Route::middleware(['auth', 'role:STUDENT,Student,student'])->prefix('student')->name('student.')->group(function () {
    Route::get('scholarships', [\App\Http\Controllers\Student\ScholarshipController::class, 'index'])->name('scholarships');
    Route::get('dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Application Flow
    Route::get('applications', [\App\Http\Controllers\Student\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/show/{application}', [\App\Http\Controllers\Student\ApplicationController::class, 'show'])->name('applications.show');
    
    Route::middleware(['verified'])->group(function () {
        Route::get('applications/create/{scholarship}', [\App\Http\Controllers\Student\ApplicationController::class, 'create'])->name('applications.create');
        Route::post('applications', [\App\Http\Controllers\Student\ApplicationController::class, 'store'])->name('applications.store');
    });
});
/* End Student */

/* Admin */
Route::middleware(['auth', 'role:ADMIN,Admin,admin'])->prefix('admin')->name('admin.')->group(function () {
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

    Route::get('applications', [\App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{application}', [\App\Http\Controllers\Admin\ApplicationController::class, 'show'])->name('applications.show');
    Route::post('applications/{application}/status', [\App\Http\Controllers\Admin\ApplicationController::class, 'updateStatus'])->name('applications.status');

    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('users/store', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Reports & Analytics
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
        Route::get('/applications', [\App\Http\Controllers\Admin\ReportController::class, 'applications'])->name('applications');
        Route::get('/export/applications', [\App\Http\Controllers\Admin\ReportController::class, 'exportApplications'])->name('export.applications');
    });

    // System Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
    });
});
/* End Admin */