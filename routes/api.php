<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Rute Publik (Bisa diakses tanpa login)
Route::post('/login', [AuthController::class, 'login']);

// Rute Terproteksi (Hanya bisa diakses jika membawa Token Sesi)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/session', [AuthController::class, 'session']); // Cek sesi user aktif
    Route::post('/logout', [AuthController::class, 'logout']);  // Hapus sesi / logout
});