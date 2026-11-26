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
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\OrganizerEventController;
use App\Http\Controllers\OrganizerParticipationController;
use App\Http\Controllers\EventReviewController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    $events = Event::with(['category', 'organization'])
        ->where('status', 'approved')
        ->where('start_date', '>=', now())
        ->orderBy('start_date', 'asc')
        ->take(3)
        ->get();

    return view('welcome', compact('events'));
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


Route::middleware(['auth', 'student'])->group(function () {
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
    Route::post('/mahasiswa/tiket/{ticketCode}/ulasan', [EventReviewController::class, 'store'])->name('reviews.store');
    Route::get('/mahasiswa/tiket/{ticketCode}/sertifikat', [CertificateController::class, 'download'])->name('certificates.download');
});

Route::middleware(['auth', 'organizer'])->prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/dashboard', [OrganizerEventController::class, 'index'])->name('dashboard');
    Route::get('/acara/buat', [OrganizerEventController::class, 'create'])->name('events.create');
    Route::post('/acara', [OrganizerEventController::class, 'store'])->name('events.store');
    Route::get('/acara/{id}/edit', [OrganizerEventController::class, 'edit'])->name('events.edit');
    Route::put('/acara/{id}', [OrganizerEventController::class, 'update'])->name('events.update');
    Route::delete('/acara/{id}', [OrganizerEventController::class, 'destroy'])->name('events.destroy');
    Route::get('/acara/{event}/peserta', [OrganizerParticipationController::class, 'participants'])->name('events.participants');
    Route::get('/presensi', [OrganizerParticipationController::class, 'attendanceIndex'])->name('attendance.index');
    Route::get('/presensi/{event}', [OrganizerParticipationController::class, 'attendance'])->name('attendance.show');
    Route::post('/presensi/{event}', [OrganizerParticipationController::class, 'checkIn'])->name('attendance.check-in');
    Route::get('/ulasan', [OrganizerParticipationController::class, 'reviews'])->name('reviews.index');
});

Route::middleware('auth')->post('/notifikasi/{notification}/baca', [NotificationController::class, 'markRead'])
    ->name('notifications.read');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminEventController::class, 'index'])->name('admin.dashboard');

    Route::get('/events/{id}', [AdminEventController::class, 'show'])->name('admin.events.show');
    Route::post('/events/{id}/approve', [AdminEventController::class, 'approve'])->name('admin.events.approve');
    Route::post('/events/{id}/reject', [AdminEventController::class, 'reject'])->name('admin.events.reject');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/{id}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
});

require __DIR__ . '/admin_transactions.php';
require __DIR__ . '/organizer_payments.php';
