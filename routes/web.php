<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/verify-email-otp', [VerifyEmailController::class, 'showOtpForm'])
    ->name('notice');
// Route to handle OTP submission
Route::post('/verify-email-otp', [VerifyEmailController::class, 'verifyOtp'])
    ->name('verify');

// Route to resend the OTP email
Route::post(
    '/send-verification',
    [VerifyEmailController::class, 'sendVerificationOtp']
)
    ->middleware('throttle:6,1')
    ->name('send');


Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->name('password.confirm');

Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

Route::put('password', [PasswordController::class, 'update'])->name('password.update');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('project', ProjectController::class);
Route::get('/task/my-tasks', [TaskController::class, 'myTasks'])
    ->name('task.myTasks');
Route::resource('task', TaskController::class);
Route::resource('user', UserController::class);

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

require __DIR__ . '/auth.php';
