<?php

use App\Http\Controllers\Api\LeadApiController;
use Illuminate\Support\Facades\Route;

Route::post('/leads', [LeadApiController::class, 'store'])->middleware('throttle:10,1');

Route::middleware('auth')->group(function () {
    Route::get('/leads', [LeadApiController::class, 'index']);
    Route::get('/leads/{lead}', [LeadApiController::class, 'show']);
});
