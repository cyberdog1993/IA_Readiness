<?php

use App\Http\Controllers\Api\LeadApiController;
use Illuminate\Support\Facades\Route;

Route::get('/leads', [LeadApiController::class, 'index']);
Route::post('/leads', [LeadApiController::class, 'store']);
Route::get('/leads/{lead}', [LeadApiController::class, 'show']);
