<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterStep1']);
Route::post('/register', [AuthController::class, 'registerStep1']);

Route::get('/register/account', [AuthController::class, 'showRegisterStep2']);
Route::post('/register/account', [AuthController::class, 'registerStep2']);


Route::get('/users-json', function(){
    return User::all();
});

Route::get('/', function () {
    return view('pages.dashboard');
})->middleware('auth');

// doctor
Route::get('/doctor',[UserController::class,'dokterIndex']);

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



