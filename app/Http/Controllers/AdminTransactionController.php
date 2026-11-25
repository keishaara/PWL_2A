<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'event.organization'])
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
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('event', function ($eq) use ($search) {
                      $eq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(10)->withQueryString();

        $totalTurnover = Payment::where('status', 'paid')->sum('amount');
        $potentialTurnover = Payment::whereIn('status', ['pending', 'waiting_verification'])->sum('amount');
        $totalPaidTransactions = Payment::where('status', 'paid')->count();
        $totalTransactions = Payment::count();

        $stats = [
            'total_turnover'       => $totalTurnover,
            'potential_turnover'   => $potentialTurnover,
            'paid_count'           => $totalPaidTransactions,
            'waiting_count'        => Payment::where('status', 'waiting_verification')->count(),
            'pending_count'        => Payment::where('status', 'pending')->count(),
            'rejected_count'       => Payment::where('status', 'rejected')->count(),
            'total_transactions'   => $totalTransactions,
        ];

        $eventSummaries = Event::has('payments')
            ->withCount(['payments as paid_payments_count' => function ($q) {
                $q->where('status', 'paid');
            }])
            ->withSum(['payments as total_revenue' => function ($q) {
                $q->where('status', 'paid');
            }], 'amount')
            ->with('organization')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        $allPaidEvents = Event::has('payments')->get(['id', 'title']);

        return view('admin.transactions.index', compact('transactions', 'stats', 'eventSummaries', 'allPaidEvents'));
    }

    public function export(Request $request)
    {
        $query = Payment::with(['user', 'event.organization'])
            ->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'waiting_verification', 'paid', 'rejected'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        $payments = $query->get();

        $headers = [
            'No',
            'No. Invoice',
            'Nama Acara',
            'Penyelenggara / Ormawa',
            'Nama Mahasiswa',
            'NPM',
            'Email',
            'Bank Tujuan',
            'Nominal (Rp)',
            'Status',
            'Waktu Konfirmasi / Bayar',
            'Waktu Transaksi',
        ];

        $rows = [];
        $no = 1;
        foreach ($payments as $pay) {
            $rows[] = [
                $no++,
                $pay->invoice_number,
                $pay->event->title ?? '-',
                $pay->event->organization->name ?? '-',
                $pay->user->name ?? '-',
                $pay->user->npm ?? '-',
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
            ];
        }

        $totalPaid = Payment::where('status', 'paid')->sum('amount');
        $totalPending = Payment::whereIn('status', ['pending', 'waiting_verification'])->sum('amount');

        $ringkasan = [
            ['Total Dana Masuk (Lunas)', 'Rp ' . number_format($totalPaid, 0, ',', '.')],
            ['Total Dana Menunggu / Pending', 'Rp ' . number_format($totalPending, 0, ',', '.')],
            ['Total Transaksi Tercatat', Payment::count()],
            ['Waktu Export Data', now()->format('d/m/Y H:i:s')],
            // ['Waktu Export Data', \Carbon\Carbon::now()->format('d/m/Y H:i:s')],
            ['Level Akses', 'Administrator Univents Global'],
        ];

        $sheets = [
            'Semua Transaksi Kampus' => [
                'headers' => $headers,
                'rows'    => $rows,
            ],
            'Ringkasan Finansial Kampus' => [
                'headers' => ['Kategori', 'Nilai'],
                'rows'    => $ringkasan,
            ],
        ];

        $filePath = \App\Support\SimpleXlsx::create($sheets);
        $fileName = 'Rekap_Transaksi_Global_Univents_' . date('Ymd_His') . '.xlsx';

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
