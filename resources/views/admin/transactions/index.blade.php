<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Transaksi Global - Admin Univents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#162945',
                            coral: '#F45D69',
                            cyan: '#39D9C1',
                            noodle: '#FCCC6B',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    @include('admin.partials.header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('admin.partials.sidebar', ['active' => 'transactions'])

        <main class="flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Monitoring Transaksi Global</h1>
                    <p class="text-xs text-slate-500 mt-1">Rekapitulasi komprehensif data perputaran uang seluruh event & kegiatan se-kampus.</p>
                </div>
                <div>
                    <a href="{{ route('admin.transactions.export', request()->only('status', 'event_id')) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                        <i class="fa-solid fa-file-excel text-sm"></i>
                        <span>Ekspor Excel (.xlsx)</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-cyan"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Dana Masuk</span>
                        <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-brand-navy mt-2 block">
                        Rp {{ number_format($stats['total_turnover'], 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] text-teal-600 font-semibold mt-1 inline-flex items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i> {{ $stats['paid_count'] }} Transaksi Lunas
                    </span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-noodle"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Potensi Tertunda</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-brand-navy mt-2 block">
                        Rp {{ number_format($stats['potential_turnover'], 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] text-amber-600 font-semibold mt-1 inline-flex items-center gap-1">
                        <i class="fa-solid fa-clock"></i> {{ $stats['waiting_count'] + $stats['pending_count'] }} Perlu Verifikasi/Bayar
                    </span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-coral"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Verifikasi Bukti</span>
                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-brand-coral flex items-center justify-center text-sm">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-brand-coral mt-2 block">
                        {{ $stats['waiting_count'] }}
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">
                        Menunggu konfirmasi panitia
                    </span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-navy"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Transaksi</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-brand-navy flex items-center justify-center text-sm">
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-brand-navy mt-2 block">
                        {{ $stats['total_transactions'] }}
                    </span>
                    <span class="text-[11px] text-rose-500 font-medium mt-1 inline-flex items-center gap-1">
                        <i class="fa-solid fa-circle-xmark"></i> {{ $stats['rejected_count'] }} Transaksi Ditolak
                    </span>
                </div>
            </div>

            @if($eventSummaries->isNotEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-brand-navy">Top Perputaran Dana per Acara</h2>
                        <p class="text-[11px] text-slate-500">Event dengan kontribusi volume perputaran dana terbesar se-kampus.</p>
                    </div>
                    <span class="text-[11px] font-semibold text-brand-cyan bg-brand-navy px-2.5 py-1 rounded-full">
                        <i class="fa-solid fa-trophy mr-1 text-brand-noodle"></i> Highlight Event
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($eventSummaries as $evt)
                    <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/70 hover:border-brand-cyan/50 transition">
                        <div class="flex items-start justify-between gap-2">
                            <span class="text-xs font-bold text-brand-navy line-clamp-1">{{ $evt->title }}</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 whitespace-nowrap">
                                {{ $evt->paid_payments_count }} Lunas
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">
                            <i class="fa-solid fa-building-columns mr-1 text-slate-400"></i>{{ $evt->organization->name ?? 'Organisasi Mahasiswa' }}
                        </p>
                        <div class="mt-2 text-right">
                            <span class="text-xs font-extrabold text-teal-700">Rp {{ number_format($evt->total_revenue ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm mb-6">
                <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('admin.transactions.index', array_merge(request()->except('status', 'page'))) }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ !request('status') ? 'bg-brand-navy text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.transactions.index', array_merge(request()->except('page'), ['status' => 'paid'])) }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'paid' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                            Lunas ({{ $stats['paid_count'] }})
                        </a>
                        <a href="{{ route('admin.transactions.index', array_merge(request()->except('page'), ['status' => 'waiting_verification'])) }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'waiting_verification' ? 'bg-amber-500 text-white shadow-sm' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                            Verifikasi ({{ $stats['waiting_count'] }})
                        </a>
                        <a href="{{ route('admin.transactions.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-slate-700 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            Belum Bayar ({{ $stats['pending_count'] }})
                        </a>
                        <a href="{{ route('admin.transactions.index', array_merge(request()->except('page'), ['status' => 'rejected'])) }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-brand-coral text-white shadow-sm' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                            Ditolak ({{ $stats['rejected_count'] }})
                        </a>
                    </div>

                    <div class="relative min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari Invoice, Mahasiswa, Acara..."
                               class="w-full pl-9 pr-4 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.transactions.index') }}" class="absolute right-2.5 top-2 text-slate-400 hover:text-rose-500 text-xs">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3 px-4">Invoice & Tanggal</th>
                                <th class="py-3 px-4">Mahasiswa / Pembeli</th>
                                <th class="py-3 px-4">Acara & Penyelenggara</th>
                                <th class="py-3 px-4">Nominal</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Bukti Transfer</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($transactions as $trx)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-4">
                                    <div class="font-bold font-mono text-brand-navy">{{ $trx->invoice_number }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $trx->created_at->format('d M Y, H:i') }} WIB</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">{{ $trx->user->name ?? 'Mahasiswa' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $trx->user->email ?? '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs">
                                    <div class="font-semibold text-brand-navy truncate">{{ $trx->event->title ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                        <i class="fa-solid fa-building-columns text-[10px]"></i>
                                        <span>{{ $trx->event->organization->name ?? 'Panitia Acara' }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @php
                                        $badgeColor = match ($trx->status) {
                                            'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'waiting_verification' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'pending' => 'bg-slate-100 text-slate-700 border-slate-200',
                                            'rejected' => 'bg-rose-50 text-brand-coral border-rose-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                                        };
                                        $badgeIcon = match ($trx->status) {
                                            'paid' => 'fa-circle-check',
                                            'waiting_verification' => 'fa-clock',
                                            'pending' => 'fa-hourglass-start',
                                            'rejected' => 'fa-circle-xmark',
                                            default => 'fa-circle-info'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badgeColor }}">
                                        <i class="fa-solid {{ $badgeIcon }} text-[10px]"></i>
                                        {{ $trx->status_label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($trx->payment_proof)
                                        <a href="{{ asset('storage/' . $trx->payment_proof) }}" target="_blank"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-brand-navy/5 text-brand-navy hover:bg-brand-navy hover:text-white transition border border-slate-200">
                                            <i class="fa-solid fa-image"></i>
                                            <span>Lihat Bukti</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-[11px] italic">Belum ada</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700">Belum ada data transaksi</p>
                                    <p class="text-xs text-slate-400 mt-1">Tidak ada transaksi yang sesuai dengan filter yang dipilih.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    {{ $transactions->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>

    <footer class="w-full bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 mt-12">
        <div class="max-w-7xl mx-auto px-4">
            &copy; {{ date('Y') }} Evently (Univents). Monitoring Transaksi Global Perputaran Keuangan Kampus.
        </div>
    </footer>
    @include('admin.partials.footer')
</body>
</html>
