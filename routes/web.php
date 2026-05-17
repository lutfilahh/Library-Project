<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// ── Root ──
Route::get('/', fn() => redirect()->route('login'));

// ── Auth (guest only) ──
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════
// ADMIN
// ══════════════════════════════════════════════
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // ── Dashboard Buku ──
    Route::get('/buku/dashboard',       [BukuController::class, 'showDashboard'])->name('buku.dashboard');
    Route::get('/buku/create',     [BukuController::class, 'showCreateBuku'])->name('buku.create');
    Route::post('/buku',           [BukuController::class, 'create'])->name('buku.store');
    Route::get('/buku/{id}/edit',  [BukuController::class, 'showUpdate'])->name('buku.edit');
    Route::put('/buku/{id}',       [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}',    [BukuController::class, 'destroy'])->name('buku.destroy');

    // ── Peminjaman ──
    Route::get('/pinjam',                  [PinjamController::class, 'index'])->name('pinjam.index');
    Route::post('/pinjam',                 [PinjamController::class, 'store'])->name('pinjam.store');
    Route::patch('/pinjam/{id}/kembalikan',[PinjamController::class, 'kembalikan'])->name('pinjam.kembalikan');
    Route::delete('/pinjam/{id}',          [PinjamController::class, 'destroy'])->name('pinjam.destroy');

    // // ── Anggota ──
    Route::get('/member',         [MemberController::class, 'index'])->name('member.index');
    Route::post('/member',        [MemberController::class, 'store'])->name('member.store');
    Route::put('/member/{id}',    [MemberController::class, 'update'])->name('member.update');
    Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
});

// ══════════════════════════════════════════════
// MEMBER
// ══════════════════════════════════════════════
Route::middleware('auth')->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', fn() => view('member.dashboard'))->name('dashboard');
});

// Landing
Route::get('/', function () {
    return view('auth.landing');
});
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

//Login
Route::get('/', function () {
    return view('auth.landing');
})->name('landing');