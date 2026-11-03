<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran & Tagihan - Univents</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#162945',
                            coral: '#F45D69',
                            cyan: '#39D9C1',
                            amber: '#FCCC6B',
                            bg: '#F8FAFC'
                        }
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
    </style>
</head>
<body class="bg-brand-bg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight text-white hidden sm:inline">Uni<span class="text-brand-cyan">vents</span></span>
                </a>

                <div class="hidden sm:block h-5 w-[1px] bg-white/20"></div>

                <nav class="hidden sm:flex items-center gap-4 text-xs font-semibold text-white/80">
                    <a href="{{ route('payments.index') }}" class="text-brand-cyan font-bold transition">Status Pembayaran</a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('profile.show') }}" class="flex items-center gap-2 text-xs font-semibold text-white/90 hover:text-white transition">
                    <div class="w-7 h-7 rounded-full bg-brand-cyan/20 border border-brand-cyan flex items-center justify-center text-brand-cyan font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                </a>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        <aside class="w-full md:w-64 shrink-0 space-y-4">
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Navigasi Akun</div>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy transition">
                    <i class="fa-solid fa-house w-4 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy transition">
                    <i class="fa-solid fa-compass w-4 text-center"></i>
                    <span>Katalog Acara</span>
                </a>

                <a href="{{ route('payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold bg-brand-navy text-white shadow-sm transition">
                    <i class="fa-solid fa-receipt w-4 text-center text-brand-cyan"></i>
                    <span>Status Pembayaran</span>
                </a>

                <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy transition">
                    <i class="fa-solid fa-user w-4 text-center"></i>
                    <span>Profil Mahasiswa</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-brand-coral hover:bg-rose-50 transition text-left">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>

            <div class="bg-brand-navy text-white p-5 rounded-2xl border border-slate-800 shadow-sm text-center">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-9 mx-auto object-contain bg-white rounded-lg p-1.5 mb-3">
                <h4 class="text-xs font-bold text-brand-cyan uppercase tracking-wider mb-1">Status Mahasiswa</h4>
                <p class="text-[11px] text-slate-300 leading-relaxed">
                    Akun kamu terverifikasi sebagai mahasiswa aktif. Cari acara seru dan kumpulkan sertifikat digital!
                </p>
            </div>
        </aside>

        <main class="flex-1 min-w-0">

        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-brand-coral uppercase tracking-wider block mb-1">
                    Manajemen Tagihan
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-navy">
                    Status Pembayaran Acara
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Pantau progres verifikasi, unduh invoice, dan unggah bukti transfer pendaftaran acara berbayar Anda.
                </p>
            </div>

            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-navy text-white text-xs font-bold hover:bg-slate-800 transition shadow-sm">
                <i class="fa-solid fa-compass"></i>
                <span>Cari Acara Menarik</span>
            </a>
        </div>

        @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if (session('info'))
        <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs sm:text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
            <div>{{ session('info') }}</div>
        </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('payments.index') }}" class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:border-brand-navy/30 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Semua Tagihan</span>
                    <i class="fa-solid fa-receipt text-slate-400"></i>
                </div>
                <div class="text-xl sm:text-2xl font-extrabold text-brand-navy mt-2">
                    {{ $stats['total'] }}
                </div>
            </a>

            <a href="{{ route('payments.index', ['status' => 'waiting_verification']) }}" class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:border-blue-400 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-blue-600">Menunggu Verifikasi</span>
                    <i class="fa-solid fa-clock-rotate-left text-blue-500"></i>
                </div>
                <div class="text-xl sm:text-2xl font-extrabold text-blue-700 mt-2">
                    {{ $stats['waiting_verification'] }}
                </div>
            </a>

            <a href="{{ route('payments.index', ['status' => 'paid']) }}" class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:border-emerald-400 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-emerald-600">Lunas / Terverifikasi</span>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                </div>
                <div class="text-xl sm:text-2xl font-extrabold text-emerald-700 mt-2">
                    {{ $stats['paid'] }}
                </div>
            </a>

            <a href="{{ route('payments.index', ['status' => 'rejected']) }}" class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:border-rose-400 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-rose-600">Ditolak</span>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                </div>
                <div class="text-xl sm:text-2xl font-extrabold text-rose-700 mt-2">
                    {{ $stats['rejected'] }}
                </div>
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-2 mb-6 border-b border-slate-200 pb-4">
            <a href="{{ route('payments.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ !request()->filled('status') ? 'bg-brand-navy text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('payments.index', ['status' => 'waiting_verification']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'waiting_verification' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Menunggu Verifikasi ({{ $stats['waiting_verification'] }})
            </a>
            <a href="{{ route('payments.index', ['status' => 'paid']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'paid' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Lunas ({{ $stats['paid'] }})
            </a>
            <a href="{{ route('payments.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Belum Bayar ({{ $stats['pending'] }})
            </a>
            <a href="{{ route('payments.index', ['status' => 'rejected']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Ditolak ({{ $stats['rejected'] }})
            </a>
        </div>

        @if ($payments->count() > 0)
        <div class="space-y-4">
            @foreach ($payments as $payment)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm hover:shadow-md transition">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                    
                    <div class="flex items-start gap-4">
                        @if($payment->event->banner)
                            <img src="{{ asset('storage/' . $payment->event->banner) }}" alt="{{ $payment->event->title }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover border border-slate-100 flex-shrink-0">
                        @else
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 flex-shrink-0">
                                <i class="fa-regular fa-image text-2xl"></i>
                            </div>
                        @endif

                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="text-xs font-mono font-bold text-brand-navy">
                                    {{ $payment->invoice_number }}
                                </span>
                                <span class="text-slate-300">&bull;</span>
                                <span class="text-xs text-slate-400">
                                    {{ $payment->created_at->translatedFormat('d M Y, H:i') }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-brand-navy hover:text-brand-coral transition">
                                <a href="{{ route('events.show', $payment->event->slug) }}">
                                    {{ $payment->event->title }}
                                </a>
                            </h3>

                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mt-2">
                                <span>
                                    <i class="fa-solid fa-building-columns text-slate-400 mr-1"></i>
                                    {{ $payment->bank_name ?? 'Bank Mandiri' }}
                                </span>
                                <span>&bull;</span>
                                <span>
                                    Batas Bayar: <span class="font-semibold {{ $payment->status === 'pending' ? 'text-rose-600' : 'text-slate-600' }}">{{ $payment->expires_at ? $payment->expires_at->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap lg:flex-col items-center lg:items-end justify-between border-t lg:border-t-0 pt-3 lg:pt-0 border-slate-100 gap-3">
                        <div class="text-left lg:text-right">
                            <span class="text-[11px] text-slate-400 block font-medium">Nominal Tagihan:</span>
                            <span class="text-lg sm:text-xl font-extrabold text-brand-navy">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full border {{ $payment->status_badge_class }}">
                                @if($payment->status === 'paid')
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                @elseif($payment->status === 'waiting_verification')
                                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                                @elseif($payment->status === 'rejected')
                                    <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                                @else
                                    <i class="fa-solid fa-hourglass-half text-amber-600"></i>
                                @endif
                                <span>{{ $payment->status_label }}</span>
                            </span>

                            <a href="{{ route('payments.show', $payment->invoice_number) }}" class="px-3.5 py-1.5 rounded-xl bg-brand-navy text-white text-xs font-bold hover:bg-brand-coral transition inline-flex items-center gap-1.5 shadow-sm">
                                <span>Lihat Invoice</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>

                @if($payment->status === 'rejected' && $payment->rejection_reason)
                <div class="mt-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 flex items-start gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5"></i>
                    <div>
                        <span class="font-bold">Alasan Ditolak:</span> {{ $payment->rejection_reason }}
                        <a href="{{ route('payments.show', $payment->invoice_number) }}" class="text-rose-900 font-bold underline ml-1 hover:text-black">Unggah Bukti Baru</a>
                    </div>
                </div>
                @endif
            </div>
            @endforeach

            <div class="mt-6">
                {{ $payments->links() }}
            </div>
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-2xl border border-slate-200/80 p-8 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-2xl mx-auto mb-4">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h3 class="text-base font-bold text-brand-navy">Belum Ada Tagihan Pembayaran</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto mt-1 mb-6">
                Ketika Anda mendaftar kegiatan yang berbayar, invoice dan status verifikasi transfer Anda akan ditampilkan di sini.
            </p>
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-coral text-white text-xs font-bold hover:bg-[#e04d59] transition shadow-md shadow-brand-coral/30">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Jelajahi Acara Sekarang</span>
            </a>
        </div>
        @endif

    </main>
    </div>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Univents Kampus &bull; Platform Manajemen & Pendaftaran Acara Mahasiswa
    </footer>

</body>
</html>