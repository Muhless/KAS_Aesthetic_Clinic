<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('/patient', function () {
    return view('pages.patients.index');
});

Route::get('/treatment', function () {
    return view('pages.treatments.index');
});

Route::get('/doctor', function () {
    return view('pages.doctor.index');
});
