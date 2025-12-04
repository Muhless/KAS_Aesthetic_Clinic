<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalPraktekController;
use App\Http\Controllers\UserController;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

Route::get('/users-json', function () {
    return User::all();
});

Route::get('/dokters-json', function () {
    return Dokter::all();
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    });

    // dokter
    Route::get('/api/dokter/{id}', [DokterController::class, 'show']);
    Route::prefix('dokter')
        ->name('dokter.')
        ->group(function () {
            Route::get('/', [DokterController::class, 'index'])->name('index');
            Route::get('/create', [DokterController::class, 'create'])->name('create');
            Route::post('/', [DokterController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [DokterController::class, 'detail'])->name('detail');
            Route::patch('/{id}', [DokterController::class, 'update'])->name('update');
            Route::delete('/{id}', [DokterController::class, 'destroy'])->name('destroy');

        });
    // end doctor

    // jadwal praktek
    Route::prefix('jadwal-praktek')->group(function () {
        Route::get('dokter/{dokterId}', [JadwalPraktekController::class, 'index']);
        Route::post('/', [JadwalPraktekController::class, 'store']);
        Route::patch('{id}/status', [JadwalPraktekController::class, 'updateStatus']);
        Route::delete('{id}', [JadwalPraktekController::class, 'destroy']);
    });
    // end jadwal praktek

    Route::get('/perawat', [AdminController::class, 'adminIndex']);

    // patient
    Route::get('/pasien', function () {
        return view('pages.pasien.index');
    });
    // end patient

    // treatments
    Route::get('/treatment', function () {
        return view('pages.treatments.index');
    });

    Route::get('/treatment/detail', function () {
        return view('pages.treatments.detail');
    });
    // end treatments

    // product
    Route::get('/produk', function () {
        return view('pages.produk.index');
    });

    // reservasi
    Route::get('/reservasi', function () {
        return view('pages.reservasi.index');
    });
});
