<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.buku.dashboard');
        }
        return redirect()->route('member.dashboard');
    }
    return view('auth.landing');
})->name('landing');

// ── Auth ──
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register',  [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════
// ADMIN
// ══════════════════════════════════════════════
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // ── Dashboard Buku ──
    Route::get('/buku/dashboard', [BukuController::class, 'showDashboard'])->name('buku.dashboard');
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

    // ── Anggota ──
    Route::get('/anggota',         [AnggotaController::class, 'index'])->name('anggota.index');
    Route::post('/anggota',        [AnggotaController::class, 'store'])->name('anggota.store');
    Route::put('/anggota/{id}',    [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
});

// ══════════════════════════════════════════════
// MEMBER
// ══════════════════════════════════════════════
Route::middleware('auth')->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', fn() => view('member.dashboard'))->name('dashboard');
});