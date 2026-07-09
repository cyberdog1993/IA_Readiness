<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ConsultingIntakeController;
use App\Http\Controllers\ClientPortalAuthController;
use App\Http\Controllers\LeadAutomationController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LeadController::class, 'home'])->name('landing');
Route::get('/diagnostico', [LeadController::class, 'create'])->name('diagnosis.form');
Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');
Route::get('/acceso-cliente', [ClientPortalAuthController::class, 'create'])->name('portal.login');
Route::redirect('/cliente', '/acceso-cliente');
Route::post('/acceso-cliente', [ClientPortalAuthController::class, 'store'])->middleware('throttle:10,1')->name('portal.login.store');
Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('landing');
})->middleware('auth')->name('logout');
Route::post('/lead-submissions', [LeadController::class, 'store'])->middleware('throttle:5,1')->name('leads.store');
Route::get('/diagnostico/{lead}', [LeadController::class, 'show'])->name('diagnosis.show');
Route::post('/diagnostico/{lead}/contacto', [LeadController::class, 'updateContact'])->middleware('throttle:10,1')->name('diagnosis.contact.update');
Route::get('/diagnostico/{lead}/informe', [LeadController::class, 'clientPdf'])->name('diagnosis.client-pdf');
Route::post('/diagnostico/{lead}/propuesta-preliminar', [LeadController::class, 'proposal'])->middleware('throttle:5,1')->name('diagnosis.proposal');
Route::redirect('/levantamiento', '/levantamiento/cliente');
Route::view('/privacidad', 'legal.privacy')->name('privacy');
Route::view('/tratamiento-datos', 'legal.data-processing')->name('data-processing');

Route::middleware(['auth'])->group(function () {
    Route::get('/levantamiento/{section}', [ConsultingIntakeController::class, 'section'])->name('consulting-intake.section');
    Route::post('/levantamiento/{section}', [ConsultingIntakeController::class, 'store'])->name('consulting-intake.store');
    Route::get('/levantamiento/ficha/{process}', [ConsultingIntakeController::class, 'show'])->name('consulting-intake.show');

    Route::get('/exports/lead/{lead}/markdown', [ExportController::class, 'markdown'])->name('exports.markdown');
    Route::get('/exports/lead/{lead}/json', [ExportController::class, 'json'])->name('exports.json');
    Route::get('/exports/lead/{lead}/excel', [ExportController::class, 'excel'])->name('exports.excel');
    Route::get('/exports/lead/{lead}/word', [ExportController::class, 'word'])->name('exports.word');
    Route::get('/exports/lead/{lead}/cliente-pdf', [ExportController::class, 'clientPdf'])->name('exports.client-pdf');
    Route::get('/exports/lead/{lead}/interno-pdf', [ExportController::class, 'internalPdf'])->name('exports.internal-pdf');
    Route::get('/integraciones/lead/{lead}/payload', [ExportController::class, 'automationPayload'])->name('exports.payload');
    Route::post('/integraciones/lead/{lead}/dispatch', [LeadAutomationController::class, 'dispatch'])->name('lead-automation.dispatch');
});
