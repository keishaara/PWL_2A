<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function registerEvent(Request $request, $slug)
    {
        $user = Auth::user();

        $eventId = Event::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail()
            ->id;

        // cek kuota + buat pendaftaran dalam satu transaksi
        // (SELECT ... FOR UPDATE) supaya pendaftar bersamaan tidak melewati kuota
        return DB::transaction(function () use ($eventId, $user) {
            $event = Event::with('organization')
                ->whereKey($eventId)
                ->lockForUpdate()
                ->firstOrFail();

            $existingRegistration = Registration::where('event_id', $event->id)
                ->where('user_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->first();

            if ($existingRegistration) {
                if ($event->isPaid()) {
                    $payment = $existingRegistration->payment;
                    if ($payment && in_array($payment->status, ['pending', 'waiting_verification', 'rejected'])) {
                        return redirect()->route('payments.show', $payment->invoice_number)
                            ->with('info', 'Anda sudah mendaftar untuk acara ini. Silakan selesaikan pembayaran Anda.');
                    }
                }
                return redirect()->route('events.show', $event->slug)
                    ->with('info', 'Anda sudah terdaftar pada kegiatan ini.');
            }

            $totalRegistered = $event->registrations()
                ->where('status', '!=', 'cancelled')
                ->count();

            if ($totalRegistered >= $event->quota) {
                return redirect()->route('events.show', $event->slug)
                    ->with('error', 'Maaf, kuota pendaftaran untuk kegiatan ini sudah penuh.');
            }

            if ($event->isPaid()) {
                $registration = Registration::create([
                    'event_id' => $event->id,
                    'user_id'  => $user->id,
                    'status'   => 'pending',
                ]);

                $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
                $expiresAt = Carbon::now()->addHours(24);

                $payment = Payment::create([
                    'registration_id'     => $registration->id,
                    'user_id'             => $user->id,
                    'event_id'            => $event->id,
                    'invoice_number'      => $invoiceNumber,
                    'amount'              => $event->price,
                    'status'              => 'pending',
                    'bank_name'           => $event->bank_name ?? 'Bank Mandiri',
                    'bank_account_number' => $event->bank_account_number ?? '123-00-9876543-2',
                    'bank_account_holder' => $event->bank_account_holder ?? ($event->organization->name ?? 'Panitia Event'),
                    'expires_at'          => $expiresAt,
                ]);

                History::create([
                    'user_id'     => $user->id,
                    'action'      => 'Pendaftaran Event Berbayar',
                    'description' => "Mendaftar pada event {$event->title} dengan nomor tagihan {$invoiceNumber}",
                ]);

                return redirect()->route('payments.show', $payment->invoice_number)
                    ->with('success', 'Pendaftaran berhasil dibuat! Silakan lakukan pembayaran sebelum batas waktu berakhir.');
            }

            $registration = Registration::create([
                'event_id' => $event->id,
                'user_id'  => $user->id,
                'status'   => 'confirmed',
            ]);

            $ticket = Ticket::issueFor($registration);

            History::create([
                'user_id'     => $user->id,
                'action'      => 'Pendaftaran Event Gratis',
                'description' => "Berhasil mendaftar pada event gratis {$event->title}. Kode tiket: {$ticket->ticket_code}",
            ]);

            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title'   => 'Pendaftaran Berhasil',
                'message' => "Kamu terdaftar di '{$event->title}'. E-Ticket kamu: {$ticket->ticket_code}.",
            ]);

            return redirect()->route('events.show', $event->slug)
                ->with('success', "Pendaftaran berhasil! Anda telah terdaftar di acara '{$event->title}'. Kode tiket Anda: {$ticket->ticket_code}");
        });
    }

    public function show($invoice_number)
    {
        $user = Auth::user();
        $payment = Payment::with(['event.organization', 'user', 'registration'])
            ->where('invoice_number', $invoice_number)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('mahasiswa.payments.invoice', compact('payment'));
    }

    public function uploadProof(Request $request, $invoice_number)
    {
        $user = Auth::user();
        $payment = Payment::where('invoice_number', $invoice_number)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (in_array($payment->status, ['paid'])) {
            return back()->with('info', 'Tagihan ini sudah lunas.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'notes'         => 'nullable|string|max:500',
        ], [
            'payment_proof.required' => 'Wajib mengunggah foto bukti pembayaran.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.mimes'    => 'Format gambar harus jpeg, png, atau jpg.',
            'payment_proof.max'      => 'Ukuran foto maksimal adalah 3 MB.',
        ]);

        if ($payment->payment_proof && Storage::disk('public')->exists($payment->payment_proof)) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        $filePath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $payment->update([
            'payment_proof' => $filePath,
            'status'        => 'waiting_verification',
            'paid_at'       => Carbon::now(),
            'notes'         => $request->notes,
        ]);

        History::create([
            'user_id'     => $user->id,
            'action'      => 'Upload Bukti Pembayaran',
            'description' => "Mengunggah bukti pembayaran untuk tagihan {$payment->invoice_number}",
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Status pembayaran kini Menunggu Verifikasi dari pihak panitia.');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Payment::with(['event.organization', 'registration'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(8);

        $stats = [
            'total'                => Payment::where('user_id', $user->id)->count(),
            'pending'              => Payment::where('user_id', $user->id)->where('status', 'pending')->count(),
            'waiting_verification' => Payment::where('user_id', $user->id)->where('status', 'waiting_verification')->count(),
            'paid'                 => Payment::where('user_id', $user->id)->where('status', 'paid')->count(),
            'rejected'             => Payment::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        return view('mahasiswa.payments.index', compact('payments', 'stats'));
    }
}