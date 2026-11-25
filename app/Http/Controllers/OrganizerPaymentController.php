<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\History;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Ticket;
use App\Support\SimpleXlsx;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OrganizerPaymentController extends Controller
{
    protected function getOrganization(): Organization
    {
        $user = Auth::user();
        return $user->organization ?? Organization::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->name, 'description' => 'Organisasi Mahasiswa']
        );
    }

    public function index(Request $request)
    {
        $organization = $this->getOrganization();

        $eventIds = Event::where('organization_id', $organization->id)->pluck('id');

        $query = Payment::with(['user', 'event', 'registration.ticket'])
            ->whereIn('event_id', $eventIds)
            ->latest();


        if ($request->filled('status') && in_array($request->status, ['pending', 'waiting_verification', 'paid', 'rejected'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'ilike', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'ilike', "%{$search}%")
                         ->orWhere('npm', 'ilike', "%{$search}%")
                         ->orWhere('email', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('event', function ($eq) use ($search) {
                      $eq->where('title', 'ilike', "%{$search}%");
                  });
            });
        }

        $payments = $query->paginate(10)->withQueryString();

        $stats = [
            'total_income'   => (float) Payment::whereIn('event_id', $eventIds)->where('status', 'paid')->sum('amount'),
            'waiting_count'  => Payment::whereIn('event_id', $eventIds)->where('status', 'waiting_verification')->count(),
            'paid_count'     => Payment::whereIn('event_id', $eventIds)->where('status', 'paid')->count(),
            'pending_count'  => Payment::whereIn('event_id', $eventIds)->where('status', 'pending')->count(),
            'rejected_count' => Payment::whereIn('event_id', $eventIds)->where('status', 'rejected')->count(),
            'all_count'      => Payment::whereIn('event_id', $eventIds)->count(),
        ];

        $myEvents = Event::where('organization_id', $organization->id)->get(['id', 'title']);

        return view('organisasi.payments.index', compact('payments', 'stats', 'myEvents', 'organization'));
    }

    public function confirm(Request $request, $id)
    {
        $organization = $this->getOrganization();

        $payment = Payment::with(['event', 'registration', 'user'])
            ->whereHas('event', function ($q) use ($organization) {
                $q->where('organization_id', $organization->id);
            })
            ->findOrFail($id);

        if ($payment->status === 'paid') {
            return back()->with('info', 'Pembayaran ini sudah berstatus lunas sebelumnya.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status'           => 'paid',
                'paid_at'          => now(),
                'rejection_reason' => null,
            ]);

            if ($payment->registration) {
                $payment->registration->update([
                    'status' => 'confirmed',
                ]);

                $ticket = Ticket::issueFor($payment->registration);

                Notification::create([
                    'user_id' => $payment->user_id,
                    'title'   => 'Pembayaran Dikonfirmasi!',
                    'message' => "Pembayaran tiket acara '{$payment->event->title}' telah diverifikasi LUNAS. Tiket kamu ({$ticket->ticket_code}) sudah aktif.",
                ]);

                History::create([
                    'user_id'     => $payment->user_id,
                    'action'      => 'Pembayaran Dikonfirmasi Lunas',
                    'description' => "Pembayaran untuk {$payment->event->title} telah diverifikasi panitia. Kode tiket: {$ticket->ticket_code}",
                ]);
            }
        });

        return back()->with('success', "Pembayaran invoice #{$payment->invoice_number} berhasil dikonfirmasi LUNAS dan tiket telah diterbitkan ke mahasiswa.");
    }

    public function reject(Request $request, $id)
    {
        $organization = $this->getOrganization();

        $payment = Payment::with(['event', 'registration', 'user'])
            ->whereHas('event', function ($q) use ($organization) {
                $q->where('organization_id', $organization->id);
            })
            ->findOrFail($id);

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'Alasan penolakan pembayaran wajib diisi.',
            'rejection_reason.max'      => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        DB::transaction(function () use ($payment, $request) {
            $payment->update([
                'status'           => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            if ($payment->registration) {
                $payment->registration->update([
                    'status' => 'pending',
                ]);
            }


            Notification::create([
                'user_id' => $payment->user_id,
                'title'   => 'Pembayaran Ditolak',
                'message' => "Pembayaran invoice #{$payment->invoice_number} ditolak panitia. Alasan: {$request->rejection_reason}. Silakan upload ulang bukti transfer yang valid.",
            ]);

            History::create([
                'user_id'     => $payment->user_id,
                'action'      => 'Pembayaran Ditolak',
                'description' => "Pembayaran invoice #{$payment->invoice_number} ({$payment->event->title}) ditolak panitia: {$request->rejection_reason}",
            ]);
        });

        return back()->with('success', "Pembayaran invoice #{$payment->invoice_number} telah ditolak dengan alasan yang tercatat.");
    }

    public function export(Request $request)
    {
        $organization = $this->getOrganization();
        $eventIds = Event::where('organization_id', $organization->id)->pluck('id');

        $eventId = $request->query('event_id');
        if ($eventId) {
            $events = Event::where('organization_id', $organization->id)->where('id', $eventId)->get();
            $eventIds = $events->pluck('id');
        } else {
            $events = Event::where('organization_id', $organization->id)->get();
        }

        $registrations = Registration::with(['user', 'event', 'payment', 'ticket'])
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->get();

        $pendaftarHeaders = [
            'No',
            'Nama Acara',
            'Nama Peserta',
            'NPM',
            'Jurusan / Prodi',
            'Email',
            'No. WhatsApp / HP',
            'Status Registrasi',
            'Status Pembayaran',
            'Nominal (Rp)',
            'Kode Tiket',
            'Waktu Pendaftaran',
        ];

        $pendaftarRows = [];
        $no = 1;
        foreach ($registrations as $reg) {
            $statusBayar = '-';
            $nominal = 0;
            if ($reg->payment) {
                $statusBayar = match ($reg->payment->status) {
                    'pending'              => 'Belum Bayar',
                    'waiting_verification' => 'Menunggu Verifikasi',
                    'paid'                 => 'Lunas',
                    'rejected'             => 'Ditolak',
                    default                => $reg->payment->status,
                };
                $nominal = (float) $reg->payment->amount;
            } elseif (! $reg->event->isPaid()) {
                $statusBayar = 'Gratis';
            }

            $pendaftarRows[] = [
                $no++,
                $reg->event->title ?? '-',
                $reg->user->name ?? '-',
                $reg->user->npm ?? '-',
                $reg->user->major ?? '-',
                $reg->user->email ?? '-',
                $reg->user->phone ?? '-',
                ucfirst($reg->status),
                $statusBayar,
                $nominal,
                $reg->ticket->ticket_code ?? '-',
                $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-',
            ];
        }

        $payments = Payment::with(['user', 'event'])
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->get();

        $uangMasukHeaders = [
            'No',
            'No. Invoice',
            'Nama Acara',
            'Nama Pembayar',
            'Email',
            'Metode / Bank Tujuan',
            'Nominal (Rp)',
            'Status',
            'Waktu Konfirmasi / Bayar',
            'Waktu Dibuat',
            'Catatan / Alasan Penolakan',
        ];

        $uangMasukRows = [];
        $noUang = 1;
        foreach ($payments as $pay) {
            $uangMasukRows[] = [
                $noUang++,
                $pay->invoice_number,
                $pay->event->title ?? '-',
                $pay->user->name ?? '-',
                $pay->user->email ?? '-',
                $pay->bank_name ?? '-',
                (float) $pay->amount,
                match ($pay->status) {
                    'pending'              => 'Belum Bayar',
                    'waiting_verification' => 'Menunggu Verifikasi',
                    'paid'                 => 'Lunas',
                    'rejected'             => 'Ditolak',
                    default                => $pay->status,
                },
                $pay->paid_at ? $pay->paid_at->format('d/m/Y H:i') : '-',
                $pay->created_at ? $pay->created_at->format('d/m/Y H:i') : '-',
                $pay->rejection_reason ?: ($pay->notes ?: '-'),
            ];
        }

        $totalMasuk = Payment::whereIn('event_id', $eventIds)->where('status', 'paid')->sum('amount');
        $totalMenunggu = Payment::whereIn('event_id', $eventIds)->where('status', 'waiting_verification')->sum('amount');
        $totalPending = Payment::whereIn('event_id', $eventIds)->where('status', 'pending')->sum('amount');

        $ringkasanHeaders = ['Kategori Rekapitulasi', 'Nilai / Jumlah'];
        $ringkasanRows = [
            ['Total Dana Masuk (Lunas)', 'Rp ' . number_format($totalMasuk, 0, ',', '.')],
            ['Dana Menunggu Verifikasi', 'Rp ' . number_format($totalMenunggu, 0, ',', '.')],
            ['Dana Tertunda (Belum Transfer)', 'Rp ' . number_format($totalPending, 0, ',', '.')],
            ['Total Mahasiswa Terdaftar', count($registrations)],
            ['Total Transaksi Pembayaran', count($payments)],
            ['Waktu Export Data', now()->format('d/m/Y H:i:s')],
            ['Penyelenggara', $organization->name],
        ];

        $sheets = [
            'Rekap Pendaftar' => [
                'headers' => $pendaftarHeaders,
                'rows'    => $pendaftarRows,
            ],
            'Laporan Uang Masuk' => [
                'headers' => $uangMasukHeaders,
                'rows'    => $uangMasukRows,
            ],
            'Ringkasan Finansial' => [
                'headers' => $ringkasanHeaders,
                'rows'    => $ringkasanRows,
            ],
        ];

        $filePath = SimpleXlsx::create($sheets);
        $fileName = 'Laporan_Rekap_Pendaftar_Uang_Masuk_' . date('Ymd_His') . '.xlsx';

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
