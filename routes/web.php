<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Category;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookmarkController;

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
    $events = Event::with(['category', 'organization'])
        ->where('status', 'approved')
        ->orderBy('start_date', 'asc')
        ->take(3)
        ->get();
    $totalEvents = Event::where('status', 'approved')->count();
    $totalCategories = Category::count();

    return view('mahasiswa.dashboard', compact('events', 'totalEvents', 'totalCategories'));
})->middleware('auth')->name('dashboard');

Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])
    ->name('events.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/mahasiswa/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/mahasiswa/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');  
    Route::post('/events/{slug}/register', [PaymentController::class, 'registerEvent'])->name('events.register');
    
    Route::get('/mahasiswa/pembayaran', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/mahasiswa/pembayaran/{invoice_number}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/mahasiswa/pembayaran/{invoice_number}/bukti', [PaymentController::class, 'uploadProof'])->name('payments.proof.store');
    
    Route::get('/mahasiswa/tiket', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/mahasiswa/tiket/{ticket_code}/pdf', [TicketController::class, 'download'])->name('tickets.download');

    Route::get('/mahasiswa/tersimpan', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/events/{slug}/bookmark', [BookmarkController::class, 'toggle'])->name('events.bookmark');
});

Route::get('/organisasi/dashboard', function () {
    return '<h1>Halo Penyelenggara: ' . Auth::user()->name . ' 🏛️</h1><p>Kamu berhasil login!</p><form action="' . route('logout') . '" method="POST">' . csrf_field() . '<button type="submit">Logout</button></form>';
})->middleware('auth')->name('organisasi.dashboard');

Route::get('/admin/dashboard', function () {
    return '<h1>Halo Admin: ' . Auth::user()->name . ' 👑</h1><p>Kamu berhasil login!</p><form action="' . route('logout') . '" method="POST">' . csrf_field() . '<button type="submit">Logout</button></form>';
})->middleware('auth')->name('admin.dashboard');