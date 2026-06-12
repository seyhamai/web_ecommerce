<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // If the user is already logged in...
    if (Auth::check()) {
        // Send Admin to dashboard, send Customer to the store layout catalog
        return Auth::user()->role_id == 1
            ? redirect()->route('admin.dashboard')
            : redirect()->route('store.index');
    }

    // If they are a stranger/guest, send them straight to the login form
    return redirect()->route('login');
});
// =========================================================================
// 1. GUEST ROUTES (Only accessible if NOT logged in)
// =========================================================================
Route::middleware('guest')->group(function () {
    // Login Screen Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registration Screen Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // 1. Show the Forgot Password form
Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');

// 2. Process the email submission and send the link (THIS WAS MISSING)
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// 3. Show the actual Reset Password form when they click the email link (CHANGED TO GET & RENAMED)
Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');

// 4. Process the new password submission
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// =========================================================================
// 2. PROTECTED ROUTES (Must be logged in - Both Admins & Customers)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/store', function () {
        return view('store.index');
    })->name('store.index');

    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

        // Main Admin Dashboard Overview
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});
