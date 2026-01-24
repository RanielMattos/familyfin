<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxonomyController;

Route::get('/taxonomia', [TaxonomyController::class, 'index']);

Route::middleware(['auth', 'family.access'])->get('/f/{family}/ping', function () {
    return response()->json(['ok' => true]);
});
