<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyDashboardController;
use App\Http\Controllers\FamilyPlanpagPageController;
use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\PlanpagController;
use App\Http\Controllers\FamilyBillsController;

use App\Http\Middleware\EnsureFamilyAccess;
use App\Http\Middleware\AutoActivateFamily;

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
| Public endpoints (tests depend on these being public)
|--------------------------------------------------------------------------
| Must NOT be inside auth middleware.
*/
Route::get('/taxonomia', [TaxonomyController::class, 'index']);
Route::get('/planpag', [PlanpagController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Authenticated UI (Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Family management (global, not /f/{family})
    |--------------------------------------------------------------------------
    */
    Route::post('/families', [FamilyController::class, 'store'])->name('families.store');

    // Ativa manualmente uma família (middleware garante que o usuário é membro)
    Route::post('/families/{family}/activate', [FamilyController::class, 'activate'])
        ->middleware(EnsureFamilyAccess::class)
        ->name('families.activate');

    /*
    |--------------------------------------------------------------------------
    | Family tenancy core (tests depend on this)
    |--------------------------------------------------------------------------
    */
    Route::get('/f/{family}/ping', function () {
        return response()->json(['ok' => true]);
    })->middleware(EnsureFamilyAccess::class);

    /*
    |--------------------------------------------------------------------------
    | Family-scoped routes (product UI)
    |--------------------------------------------------------------------------
    | Ordem importa:
    | 1) EnsureFamilyAccess: garante que o usuário é membro e resolve o {family}
    | 2) AutoActivateFamily: marca esta family como ativa para o usuário
    */
    Route::prefix('/f/{family}')
        ->middleware([EnsureFamilyAccess::class, AutoActivateFamily::class])
        ->group(function () {
            Route::get('/dashboard', [FamilyDashboardController::class, 'index'])
                ->name('family.dashboard');

            // UI (HTML)
            Route::get('/planpag', FamilyPlanpagPageController::class)
                ->name('family.planpag');

            // Já existente (JSON)
            Route::get('/taxonomia', [TaxonomyController::class, 'index'])
                ->name('family.taxonomy');

            // Bills routes
            Route::get('/bills/create', [FamilyBillsController::class, 'create'])
                ->name('family.bills.create');

            Route::post('/bills', [FamilyBillsController::class, 'store'])
                ->name('family.bills.store');

            Route::get('/bills', [FamilyBillsController::class, 'index'])
                ->name('family.bills.index');

            Route::get('bills/{bill}/edit', [FamilyBillsController::class, 'edit'])
                ->name('family.bills.edit');

            Route::put('bills/{bill}', [FamilyBillsController::class, 'update'])
                ->name('family.bills.update');

            Route::delete('bills/{bill}', [FamilyBillsController::class, 'destroy'])
                ->name('family.bills.destroy');

        });
});

/*
|--------------------------------------------------------------------------
| Breeze auth routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
