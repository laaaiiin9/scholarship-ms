<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\ScholarshipController as AdminScholarshipController;
use App\Http\Controllers\Admin\ApplicationPeriodController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\RenewalReviewController;
use App\Http\Controllers\Admin\RenewalPeriodController;
use App\Http\Controllers\Admin\DisbursementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\ScholarshipController as StudentScholarshipController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ApplicationController as StudentApplicationController;
use App\Http\Controllers\Student\RenewalController as StudentRenewalController;
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
    Route::get('scholarships', [StudentScholarshipController::class, 'index'])->name('scholarships');
    Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Application Flow
    Route::get('applications', [StudentApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/show/{application}', [StudentApplicationController::class, 'show'])->name('applications.show');
    
    Route::middleware(['verified'])->group(function () {
        Route::get('applications/create/{scholarship}', [StudentApplicationController::class, 'create'])->name('applications.create');
        Route::post('applications', [StudentApplicationController::class, 'store'])->name('applications.store');
        
        // Renewal Flow
        Route::get('renewals', [StudentRenewalController::class, 'index'])->name('renewals.index');
        Route::get('renewals/create/{application}', [StudentRenewalController::class, 'create'])->name('renewals.create');
        Route::post('renewals', [StudentRenewalController::class, 'store'])->name('renewals.store');
    });
});
/* End Student */

/* Admin */
Route::middleware(['auth', 'role:ADMIN,Admin,admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('scholarships', [AdminScholarshipController::class, 'index'])->name('scholarships');
    Route::get('requirements', [RequirementController::class, 'index'])->name('requirements');
    Route::post('requirements/store', [RequirementController::class, 'store'])->name('requirements.store');
    Route::get('requirements/{requirement}/edit', [RequirementController::class, 'edit'])->name('requirements.edit');
    Route::put('requirements/{requirement}', [RequirementController::class, 'update'])->name('requirements.update');
    Route::delete('requirements/{requirement}', [RequirementController::class, 'destroy'])->name('requirements.destroy');
    Route::post('scholarships/store', [AdminScholarshipController::class, 'store'])->name('scholarships.store');
    Route::get('scholarships/{scholarship}/edit', [AdminScholarshipController::class, 'edit'])->name('scholarships.edit');
    Route::put('scholarships/{scholarship}', [AdminScholarshipController::class, 'update'])->name('scholarships.update');
    Route::delete('scholarships/{scholarship}', [AdminScholarshipController::class, 'destroy'])->name('scholarships.destroy');

    Route::get('application-periods', [ApplicationPeriodController::class, 'index'])->name('application-periods');
    Route::post('application-periods/store', [ApplicationPeriodController::class, 'store'])->name('application-periods.store');
    Route::get('application-periods/{applicationPeriod}/edit', [ApplicationPeriodController::class, 'edit'])->name('application-periods.edit');
    Route::put('application-periods/{applicationPeriod}', [ApplicationPeriodController::class, 'update'])->name('application-periods.update');
    Route::delete('application-periods/{applicationPeriod}', [ApplicationPeriodController::class, 'destroy'])->name('application-periods.destroy');

    Route::get('applications', [AdminApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
    Route::post('applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.status');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Reports & Analytics
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/applications', [ReportController::class, 'applications'])->name('applications');
        Route::get('/export/applications', [ReportController::class, 'exportApplications'])->name('export.applications');
    });

    // System Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/update', [SettingController::class, 'update'])->name('update');
    });

    // Renewals & Disbursements
    Route::prefix('renewals')->name('renewals.')->group(function () {
        Route::get('/', [RenewalReviewController::class, 'index'])->name('index');
        Route::get('/{renewal}', [RenewalReviewController::class, 'show'])->name('show');
        Route::post('/{renewal}/status', [RenewalReviewController::class, 'update'])->name('status');
        
        Route::get('/periods', [RenewalPeriodController::class, 'index'])->name('periods.index');
        Route::post('/periods/store', [RenewalPeriodController::class, 'store'])->name('periods.store');
        Route::get('/periods/{renewalPeriod}/edit', [RenewalPeriodController::class, 'edit'])->name('periods.edit');
        Route::put('/periods/{renewalPeriod}', [RenewalPeriodController::class, 'update'])->name('periods.update');
        Route::delete('/periods/{renewalPeriod}', [RenewalPeriodController::class, 'destroy'])->name('periods.destroy');
    });

    Route::prefix('disbursements')->name('disbursements.')->group(function () {
        Route::get('/', [DisbursementController::class, 'index'])->name('index');
        Route::post('/{disbursement}', [DisbursementController::class, 'update'])->name('update');
    });
});
/* End Admin */