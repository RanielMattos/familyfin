<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'family.access'])->get('/f/{family}/ping', function () {
    return response()->json(['ok' => true]);
});
