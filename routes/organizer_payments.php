<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerPaymentController;

Route::middleware(['auth', 'organizer'])->prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/pembayaran', [OrganizerPaymentController::class, 'index'])->name('payments.index');
    Route::post('/pembayaran/{id}/konfirmasi', [OrganizerPaymentController::class, 'confirm'])->name('payments.confirm');
    Route::post('/pembayaran/{id}/tolak', [OrganizerPaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/laporan/export-excel', [OrganizerPaymentController::class, 'export'])->name('payments.export');
});
