<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// ── Halaman publik ──
Route::get('/', function () {
    return redirect()->route('login');
});

// ── Auth 
Route::middleware('guest')->group(function () {
    //login
    Route::get('/login',  [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    //Registasi
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

// ── Logout ──
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Area Admin 
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
});

// ── Area Member ──
Route::middleware('auth')->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', fn() => view('member.dashboard'))->name('dashboard');
});