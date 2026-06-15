<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {

    if (Auth::check()) {

        return Auth::user()->role_id == 1
            ? redirect()->route('admin.dashboard')
            : redirect()->route('store.index');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');


    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');


    Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});


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
    // manage users
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user:public_id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user:public_id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user:public_id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/export', [UserController::class, 'exportUsers'])->name('exportUsers');
});
