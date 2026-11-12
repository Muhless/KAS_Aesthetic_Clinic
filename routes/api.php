<?php

use App\Http\Controllers\E2e\VisitController;
use App\Http\Controllers\TreatmentController;
use Illuminate\Support\Facades\Route;

/*
 * API JSON untuk kebutuhan pengujian e2e (membuat/mengubah/menghapus data
 * lewat HTTP, tanpa harus melewati UI).
 *
 * Memakai session auth (middleware "web") supaya bisa memakai akun admin yang
 * sama dengan UI; CSRF token dikirim lewat header X-CSRF-TOKEN.
 */
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/treatment', [TreatmentController::class, 'index'])->name('api.treatment.index');
    Route::get('/treatment/{id}', [TreatmentController::class, 'show'])->name('api.treatment.show');
    Route::post('/treatment', [TreatmentController::class, 'store'])->name('api.treatment.store');
    Route::match(['put', 'patch'], '/treatment/{id}', [TreatmentController::class, 'update'])->name('api.treatment.update');
    Route::delete('/treatment/{id}', [TreatmentController::class, 'destroy'])->name('api.treatment.destroy');
});

/*
 * Endpoint pembuat data khusus e2e. Hanya didaftarkan saat APP_ENV=testing
 * supaya tidak pernah bisa dipanggil di production.
 */
if (app()->environment('testing')) {
    Route::middleware(['web', 'auth'])->prefix('e2e')->group(function () {
        Route::get('/catalog', [VisitController::class, 'catalog'])->name('api.e2e.catalog');
        Route::post('/visits', [VisitController::class, 'store'])->name('api.e2e.visits.store');
        Route::delete('/visits/{id}', [VisitController::class, 'destroy'])->name('api.e2e.visits.destroy');
    });
}
