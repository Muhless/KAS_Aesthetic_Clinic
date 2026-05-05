<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\PerawatDashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TreatmentController;
use App\Models\Perawat;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterUser']);
Route::post('/register', [AuthController::class, 'registerUser']);

Route::get('/register/admin', [AuthController::class, 'showRegisterAdmin']);
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);

Route::get('/register/dokter', [AuthController::class, 'showRegisterDokter']);
Route::post('/register/dokter', [AuthController::class, 'registerDokter']);

Route::get('/register/perawat', [AuthController::class, 'showRegisterPerawat']);
Route::post('/register/perawat', [AuthController::class, 'registerPerawat']);

// routes/web.php
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('reservasi', ReservasiController::class);
    Route::get('/api/reservasi', [ReservasiController::class, 'api']);

    Route::resource('pasien', PasienController::class);
    Route::get('/api/pasien', [PasienController::class, 'api']);

    Route::resource('perawat', PerawatController::class);
    Route::get('/api/perawat', [PerawatController::class, 'api']);

    Route::middleware(['auth', 'role:dokter'])->group(function () {
        Route::get('/dokter/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');
        Route::resource('pemeriksaan', PemeriksaanController::class);
    });

    Route::resource('dokter', DokterController::class);
    Route::get('/api/dokter', [DokterController::class, 'api']);
    Route::get('/dokter/detail/{id}', [DokterController::class, 'detail'])->name('dokter.detail');

    Route::resource('produk', ProdukController::class);
    Route::get('/api/produk', [ProdukController::class, 'api']);

    Route::resource('treatment', TreatmentController::class);
    Route::get('/api/treatment', [TreatmentController::class, 'api']);

    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('/api/keuangan', [KeuanganController::class, 'api']);

    Route::resource('pelayanan', PelayananController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::post('pemeriksaan', [PemeriksaanController::class, 'store'])->name('pemeriksaan.store');

    Route::resource('pelayanan', PelayananController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::post('pemeriksaan', [PemeriksaanController::class, 'store'])->name('pemeriksaan.store');
    Route::post('pembayaran/{id}/item', [PembayaranController::class, 'addItem'])->name('pembayaran.addItem');
    Route::delete('pembayaran/item/{id}', [PembayaranController::class, 'removeItem'])->name('pembayaran.removeItem');
    Route::post('pembayaran/{id}/bayar', [PembayaranController::class, 'bayar'])->name('pembayaran.bayar');
});

Route::get('/test-dokter', [DokterDashboardController::class, 'index']);

// Perawat only
Route::middleware(['auth', 'role:perawat'])->group(function () {
    Route::get('/perawat/dashboard', [PerawatDashboardController::class, 'index'])->name('perawat.dashboard');
});

// Bisa diakses admin dan dokter
Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    Route::resource('pelayanan', PelayananController::class);
});
