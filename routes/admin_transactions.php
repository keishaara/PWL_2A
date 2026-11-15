<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminTransactionController;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/transaksi', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/transaksi/export-excel', [AdminTransactionController::class, 'export'])->name('admin.transactions.export');
});
