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

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user:public_id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user:public_id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user:public_id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/export', [UserController::class, 'exportUsers'])->name('users.export');
        Route::patch('/users/{public_id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/users/{public_id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('index');
            Route::post('/', [\App\Http\Controllers\CategoryController::class, 'store'])->name('store');
            Route::put('/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('destroy');
        });
    });
});
