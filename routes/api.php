<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TreatmentController;

   Route::get('/dokter', [DokterController::class, 'api']);

    Route::get('/dokter/detail/{id}', [DokterController::class, 'detail'])->name('dokter.detail');
    Route::apiResource('perawat', PerawatController::class);
    Route::apiResource('pasien', PasienController::class);
    Route::apiResource('treatment', TreatmentController::class);
    Route::apiResource('produk', ProdukController::class);
    Route::apiResource('reservasi', ReservasiController::class);
