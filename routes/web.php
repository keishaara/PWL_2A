<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman registrasi
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Proses registrasi
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');