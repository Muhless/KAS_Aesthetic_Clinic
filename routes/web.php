<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterStep1']);
Route::post('/register', [AuthController::class, 'registerStep1']);

Route::get('/register/account', [AuthController::class, 'showRegisterStep2']);
Route::post('/register/account', [AuthController::class, 'registerStep2']);

// routes/web.php
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/users-json', function(){
    return User::all();
});

Route::get('/', function () {
    return view('pages.dashboard');
})->middleware('auth');

// dokter
Route::prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', [DokterController::class, 'index'])->name('index');
    Route::get('/create', [DokterController::class, 'create'])->name('create');
    Route::post('/', [DokterController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [DokterController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DokterController::class, 'update'])->name('update');
    Route::delete('/{id}', [DokterController::class, 'destroy'])->name('destroy');
});
// end doctor

Route::get('/perawat', [AdminController::class,'adminIndex']);

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
    return view ('pages.produk.index');
});



