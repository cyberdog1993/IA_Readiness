<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ConsultingIntakeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LeadController::class, 'create'])->name('landing');
Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');
Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('landing');
})->middleware('auth')->name('logout');
Route::post('/lead-submissions', [LeadController::class, 'store'])->name('leads.store');
Route::get('/diagnostico/{lead}', [LeadController::class, 'show'])->name('diagnosis.show');
Route::redirect('/levantamiento', '/levantamiento/cliente');

Route::middleware(['auth'])->group(function () {
    Route::get('/levantamiento/{section}', [ConsultingIntakeController::class, 'section'])->name('consulting-intake.section');
    Route::post('/levantamiento/{section}', [ConsultingIntakeController::class, 'store'])->name('consulting-intake.store');
    Route::get('/levantamiento/ficha/{process}', [ConsultingIntakeController::class, 'show'])->name('consulting-intake.show');

    Route::get('/exports/lead/{lead}/markdown', [ExportController::class, 'markdown'])->name('exports.markdown');
    Route::get('/exports/lead/{lead}/json', [ExportController::class, 'json'])->name('exports.json');
    Route::get('/exports/lead/{lead}/excel', [ExportController::class, 'excel'])->name('exports.excel');
    Route::get('/exports/lead/{lead}/word', [ExportController::class, 'word'])->name('exports.word');
});
