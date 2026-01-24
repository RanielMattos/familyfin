<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\PlanpagController;

use App\Http\Middleware\EnsureFamilyAccess;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Public API (tests depend on these being public)
|--------------------------------------------------------------------------
*/
Route::get('/taxonomia', [TaxonomyController::class, 'index']);
Route::get('/planpag', [PlanpagController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Authenticated UI (Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Profile (Breeze)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Family tenancy core routes (tests depend on these)
    |--------------------------------------------------------------------------
    */
    Route::get('/f/{family}/ping', function () {
        return response()->json(['ok' => true]);
    })->middleware(EnsureFamilyAccess::class);
});

/*
|--------------------------------------------------------------------------
| Breeze auth routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
