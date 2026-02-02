<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AspirasiController as AdminAspirasi;
use App\Http\Controllers\Admin\KategoriController as AdminKategori;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Siswa\AspirasiController;

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
    
    // Kelola Aspirasi
    Route::get('/aspirasi', [AdminAspirasi::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{id}', [AdminAspirasi::class, 'show'])->name('aspirasi.show');
    Route::put('/aspirasi/{id}/status', [AdminAspirasi::class, 'updateStatus'])->name('aspirasi.updateStatus');
    Route::post('/aspirasi/{id}/umpan-balik', [AdminAspirasi::class, 'storeUmpanBalik'])->name('aspirasi.storeUmpanBalik');
    Route::delete('/aspirasi/{id}', [AdminAspirasi::class, 'destroy'])->name('aspirasi.destroy');
    
    // Kelola Kategori
    Route::get('/kategori', [AdminKategori::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [AdminKategori::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [AdminKategori::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminKategori::class, 'destroy'])->name('kategori.destroy');
    
    // Laporan
    Route::get('/laporan', [AdminLaporan::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [AdminLaporan::class, 'generate'])->name('laporan.generate');
});

// Siswa Routes (dengan middleware siswa)
Route::middleware('siswa')->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [AspirasiController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logoutSiswa'])->name('logout');
    
    // CRUD Aspirasi
    Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('/aspirasi/{id}', [AspirasiController::class, 'show'])->name('aspirasi.show');
    Route::get('/aspirasi/{id}/edit', [AspirasiController::class, 'edit'])->name('aspirasi.edit');
    Route::put('/aspirasi/{id}', [AspirasiController::class, 'update'])->name('aspirasi.update');
    Route::delete('/aspirasi/{id}', [AspirasiController::class, 'destroy'])->name('aspirasi.destroy');
    
    // Histori
    Route::get('/histori', [AspirasiController::class, 'history'])->name('aspirasi.history');
});