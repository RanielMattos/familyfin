<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\PlanpagController;

Route::get('/planpag', [PlanpagController::class, 'index']);

Route::get('/taxonomia', [TaxonomyController::class, 'index']);

Route::middleware(['auth', 'family.access'])->get('/f/{family}/ping', function () {
    return response()->json(['ok' => true]);
});
