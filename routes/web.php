<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;

// Halaman Utama (redirect ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin');
Route::post('/login-siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa');

// Admin Routes (dengan middleware auth:admin)
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logoutAdmin'])->name('logout');
});

// Siswa Routes (dengan middleware siswa)
Route::middleware('siswa')->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logoutSiswa'])->name('logout');
});