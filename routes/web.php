<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PerawatController;
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
    Route::get('/', function () {
        return view('pages.dashboard');
    });

    Route::resource('dokter', DokterController::class);
   Route::get('/api/dokter', [DokterController::class, 'api']);
   Route::get('/dokter/detail/{id}', [DokterController::class, 'detail'])->name('dokter.detail');

   Route::resource('perawat', PerawatController::class);
   Route::get('/api/perawat', [PerawatController::class, 'api']);

    Route::resource('pasien', PasienController::class);
   Route::get('/api/pasien', [PasienController::class, 'api']);

    Route::resource('treatment', TreatmentController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('reservasi', ReservasiController::class);
});
