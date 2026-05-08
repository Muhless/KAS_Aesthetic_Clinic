<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\NakesController;
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
    Route::resource('pasien', PasienController::class);
    Route::resource('perawat', PerawatController::class);
    Route::middleware(['auth', 'role:dokter,perawat'])->group(function () {
        Route::get('/nakes', [NakesController::class, 'index'])->name('nakes');
        Route::resource('pemeriksaan', PemeriksaanController::class)->only(['edit', 'update']);
    });

    Route::resource('dokter', DokterController::class);
    Route::get('/dokter/detail/{id}', [DokterController::class, 'detail'])->name('dokter.detail');
    Route::resource('produk', ProdukController::class);
    Route::resource('treatment', TreatmentController::class);

    Route::resource('keuangan', KeuanganController::class)->parameters([
        'keuangan' => 'pembayaran',
    ]);
  Route::patch('/keuangan/{pembayaran}/bayar', [PembayaranController::class, 'bayar'])->name('keuangan.bayar');

    Route::resource('pelayanan', PelayananController::class);
    Route::resource('pembayaran', PembayaranController::class);

    Route::resource('pelayanan', PelayananController::class);
    Route::resource('pembayaran', PembayaranController::class);

    Route::post('pembayaran/{id}/item', [PembayaranController::class, 'addItem'])->name('pembayaran.addItem');
    Route::delete('pembayaran/item/{id}', [PembayaranController::class, 'removeItem'])->name('pembayaran.removeItem');
    Route::post('pembayaran/{id}/bayar', [PembayaranController::class, 'bayar'])->name('pembayaran.bayar');
});
