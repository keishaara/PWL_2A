<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Univents</title>

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
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight text-white hidden sm:inline">Uni<span class="text-brand-cyan">vents</span></span>
                </a>

                <div class="hidden sm:block h-5 w-[1px] bg-white/20"></div>

                <nav class="hidden sm:flex items-center gap-3 text-xs font-semibold text-white/80">
                    <!-- <a href="{{ route('dashboard') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('events.index') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Katalog Acara</span>
                    </a> -->
                    <!-- <span class="text-white/30">/</span> -->
                    <span class="text-brand-cyan">Detail Acara</span>
                </nav>
            </div>


            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-white/10 text-white hover:bg-brand-coral transition border border-white/10">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back</span>
            </a>
            <!-- <a href="{{ route('events.index') }}" class="text-xs font-semibold text-slate-300 hover:text-white transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Jelajah Acara
            </a> -->
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow">

        @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between gap-3 shadow-sm">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                <div>{{ session('success') }}</div>
            </div>
            <a href="{{ route('payments.index') }}" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition whitespace-nowrap">
                Lihat Tiket / Tagihan Saya
            </a>
        </div>
        @endif

        @if (session('info'))
        <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 text-xs sm:text-sm flex items-center justify-between gap-3 shadow-sm">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-info text-blue-600 text-xl"></i>
                <div>{{ session('info') }}</div>
            </div>
            <a href="{{ route('payments.index') }}" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition whitespace-nowrap">
                Lihat Tagihan Saya
            </a>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center gap-3 shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-600 text-xl"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="relative rounded-3xl overflow-hidden shadow-lg bg-slate-900 border border-slate-200">
                    <img
                        src="{{ $event->banner ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1000' }}"
                        alt="{{ $event->title }}"
                        class="w-full h-80 sm:h-96 object-cover">
                    <span class="absolute top-4 left-4 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#162945]/90 text-white backdrop-blur-md border border-white/20">
                        {{ $event->category->name }}
                    </span>
                </div>

                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#162945] leading-snug">
                        {{ $event->title }}
                    </h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 rounded-xl bg-[#39D9C1]/20 text-[#0F685B] flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-clock text-base"></i>
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-[#162945]">Waktu Pelaksanaan</h4>
                                <p class="text-xs text-slate-600 mt-0.5">
                                    {{ $event->start_date->translatedFormat('l, d F Y') }}
                                </p>
                                <p class="text-[11px] text-slate-400">
                                    {{ $event->start_date->format('H:i') }} - {{ $event->end_date->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 rounded-xl bg-[#FCCC6B]/20 text-[#8F6800] flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot text-base"></i>
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-[#162945]">Lokasi Kegiatan</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                    {{ $event->location }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-base font-bold text-[#162945] mb-3">Tentang Kegiatan Ini</h3>
                        <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                            {{ $event->description }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm sticky top-24">

                    <div class="pb-4 border-b border-slate-100">
                        <span class="text-xs font-semibold text-slate-400">Status Pendaftaran</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">
                                Dibuka untuk Mahasiswa
                            </span>
                            <span class="text-xs font-bold text-[#F45D69]">
                                Sisa {{ $remainingQuota }} Kuota
                            </span>
                        </div>
                    </div>

                    <div class="py-5 space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500">Total Kuota</span>
                            <span class="font-bold text-[#162945]">{{ $event->quota }} Kursi</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500">Biaya Pendaftaran</span>
                            @if($event->isPaid())
                            <span class="font-extrabold text-brand-coral text-base">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </span>
                            @else
                            <span class="font-bold text-[#39D9C1] text-sm">GRATIS</span>
                            @endif
                        </div>
                    </div>

                    @auth
                    @php
                        $userReg = $event->registrations->where('user_id', Auth::id())->where('status', '!=', 'cancelled')->first();
                    @endphp

                    @if($userReg)
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-2">
                            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Anda Sudah Terdaftar</span>
                            </div>
                            <p class="text-[11px] text-slate-500">
                                @if($event->isPaid())
                                    Status pembayaran Anda dapat dipantau di halaman invoice / status tagihan.
                                @else
                                    Tiket gratis Anda sudah aktif.
                                @endif
                            </p>
                            <div class="pt-1">
                                @if($event->isPaid() && $userReg->payment)
                                    <a href="{{ route('payments.show', $userReg->payment->invoice_number) }}" class="inline-block w-full py-2.5 px-3 rounded-xl bg-brand-navy text-white font-bold text-xs hover:bg-slate-800 transition">
                                        Buka Invoice Tagihan
                                    </a>
                                @else
                                    <a href="{{ route('payments.index') }}" class="inline-block w-full py-2.5 px-3 rounded-xl bg-brand-navy text-white font-bold text-xs hover:bg-slate-800 transition">
                                        Lihat Status & Riwayat
                                    </a>
                                @endif
                            </div>
                        </div>
                    @elseif ($remainingQuota > 0)
                    <form action="{{ route('events.register', $event->slug) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="w-full py-3.5 px-4 rounded-xl bg-[#F45D69] text-white font-bold text-sm hover:bg-[#e04d59] transition shadow-lg shadow-[#F45D69]/30 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-ticket"></i>
                            <span>{{ $event->isPaid() ? 'Daftar & Lanjut ke Pembayaran' : 'Daftar Kegiatan Ini (Gratis)' }}</span>
                        </button>
                    </form>
                    @else
                    <button disabled class="w-full py-3.5 px-4 rounded-xl bg-slate-300 text-slate-500 font-bold text-sm cursor-not-allowed">
                        Kuota Penuh
                    </button>
                    @endif
                    @else
                    <a
                        href="{{ route('login') }}"
                        class="w-full py-3.5 px-4 rounded-xl bg-[#162945] text-white font-bold text-sm hover:bg-[#F45D69] transition shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Masuk untuk Mendaftar</span>
                    </a>
                    @endauth

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-3">
                            Penyelenggara Acara
                        </span>

                        <div class="flex items-center gap-3">
                            <img
                                src="{{ $event->organization->logo ?? 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?w=100' }}"
                                alt="{{ $event->organization->name }}"
                                class="h-12 w-12 rounded-2xl object-cover border border-slate-100">
                            <div>
                                <h4 class="text-xs font-bold text-[#162945]">{{ $event->organization->name }}</h4>
                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                                    {{ $event->organization->description }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Univents Kampus &bull; Platform Manajemen & Pendaftaran Acara Mahasiswa
    </footer>

</body>

</html>