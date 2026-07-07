<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ConsultingIntakeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LeadController::class, 'create'])->name('landing');
Route::post('/lead-submissions', [LeadController::class, 'store'])->name('leads.store');
Route::get('/diagnostico/{lead}', [LeadController::class, 'show'])->name('diagnosis.show');
Route::get('/levantamiento', [ConsultingIntakeController::class, 'create'])->name('consulting-intake.create');
Route::post('/levantamiento', [ConsultingIntakeController::class, 'store'])->name('consulting-intake.store');
Route::get('/levantamiento/{process}', [ConsultingIntakeController::class, 'show'])->name('consulting-intake.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/exports/lead/{lead}/markdown', [ExportController::class, 'markdown'])->name('exports.markdown');
    Route::get('/exports/lead/{lead}/json', [ExportController::class, 'json'])->name('exports.json');
    Route::get('/exports/lead/{lead}/excel', [ExportController::class, 'excel'])->name('exports.excel');
    Route::get('/exports/lead/{lead}/word', [ExportController::class, 'word'])->name('exports.word');
});
