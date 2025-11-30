<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);




Route::get('/', function () {
    return view('pages.dashboard');
})->middleware('auth');

// doctor
Route::get('/doctor', function () {
    return view('pages.doctor.index');
});

// end doctor

// patient
Route::get('/patient', function () {
    return view('pages.patients.index');
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
Route::get('/product', function () {
    return view ('pages.products.index');
});



