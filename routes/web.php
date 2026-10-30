<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/dashboard', function () {
    return '<h1>Halo Mahasiswa: ' . Auth::user()->name . ' 👋</h1><p>Kamu berhasil login!</p><form action="' . route('logout') . '" method="POST">' . csrf_field() . '<button type="submit">Logout</button></form>';
})->middleware('auth')->name('dashboard');

Route::get('/organisasi/dashboard', function () {
    return '<h1>Halo Penyelenggara: ' . Auth::user()->name . ' 🏛️</h1><p>Kamu berhasil login!</p><form action="' . route('logout') . '" method="POST">' . csrf_field() . '<button type="submit">Logout</button></form>';
})->middleware('auth')->name('organisasi.dashboard');

Route::get('/admin/dashboard', function () {
    return '<h1>Halo Admin: ' . Auth::user()->name . ' 👑</h1><p>Kamu berhasil login!</p><form action="' . route('logout') . '" method="POST">' . csrf_field() . '<button type="submit">Logout</button></form>';
})->middleware('auth')->name('admin.dashboard');