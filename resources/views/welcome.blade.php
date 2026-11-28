<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Univents - Official Campus Event Space</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkEclipse: '#14213D',
                        cyberNavy: '#121E38',
                        electricBlue: '#1E90FF',
                        ripeMalinka: '#FF6B5B',
                        amber: '#FCCC6B',
                        surface: '#F8F6F1',
                        cream: '#F4EDE0',
                        warm: '#E6E1D8',
                        amberDark: '#D4A017'
                    },
                    fontFamily: {
                        jakarta: ['"Plus Jakarta Sans"', 'sans-serif']
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F6F1; }
        .glow-blue  { box-shadow: 0 8px 24px -4px rgba(30, 144, 255, 0.35); }
        .glow-coral { box-shadow: 0 8px 24px -4px rgba(255, 107, 91, 0.35); }

        @keyframes floaty { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .floaty   { animation: floaty 6s ease-in-out infinite; }
        .floaty-2 { animation: floaty 7s ease-in-out infinite reverse; }
        @media (prefers-reduced-motion: reduce) { .floaty, .floaty-2 { animation: none; } }
    </style>
</head>

<body class="bg-surface text-darkEclipse antialiased min-h-screen flex flex-col font-jakarta">

    <header class="w-full bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-[72px] flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-9 w-auto object-contain">
                <span class="text-xl font-extrabold tracking-tight text-darkEclipse">Univents</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-slate-600">
                <a href="#agenda" class="hover:text-electricBlue transition">Agenda Acara</a>
                <a href="#peran" class="hover:text-electricBlue transition">Untuk Siapa</a>
                <a href="#fitur" class="hover:text-electricBlue transition">Fitur Platform</a>
                <a href="#tentang" class="hover:text-electricBlue transition">Tentang Kami</a>
            </nav>

            <div class="flex items-center gap-3 sm:gap-4">
                @if (Route::has('login'))
                @auth
                @if(Auth::user()->role === 'student')
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full bg-darkEclipse hover:bg-slate-800 text-white text-xs font-bold transition shadow-sm">Dashboard Mahasiswa</a>
                @elseif(Auth::user()->role === 'organizer')
                <a href="{{ route('organisasi.dashboard') }}" class="px-5 py-2.5 rounded-full bg-darkEclipse hover:bg-slate-800 text-white text-xs font-bold transition shadow-sm">Dashboard Ormawa</a>
                @else
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-full bg-darkEclipse hover:bg-slate-800 text-white text-xs font-bold transition shadow-sm">Dashboard Admin</a>
                @endif
                @else
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-darkEclipse transition">Masuk</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-darkEclipse hover:bg-slate-800 text-white text-xs font-bold transition shadow-sm">Daftar Akun</a>
                @endif
                @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="flex-grow">

        <section class="relative overflow-hidden bg-gradient-to-b from-white via-surface/60 to-surface px-4 sm:px-6 pt-14 pb-16 sm:pt-16">

            <div class="flex justify-center mb-5">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cream border border-darkEclipse/20 text-[11px] font-bold text-darkEclipse shadow-sm">
                    <span>✦</span>
                    <span class="uppercase tracking-wide">Official Campus Event Space</span>
                </div>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-darkEclipse text-center tracking-tight leading-[1.1] max-w-3xl mx-auto">
                Pusat Kolaborasi & Kegiatan Kampus <span class="text-electricBlue">Terintegrasi.</span>
            </h1>

            <p class="mt-5 text-sm sm:text-base text-slate-600 text-center max-w-xl mx-auto leading-relaxed">
                Temukan seminar, workshop ormawa, dan klaim tiket digital kampus dalam satu ekosistem terpadu, dari pendaftaran sampai presensi.
            </p>

            <div class="mt-7 flex flex-wrap items-center justify-center gap-3.5">
                <a href="#agenda" class="px-7 py-3 rounded-full bg-electricBlue hover:bg-[#187bcd] text-white text-xs font-bold shadow-md glow-blue transition">
                    Jelajahi Agenda <i class="fa-solid fa-bolt ml-1"></i>
                </a>
                <a href="#peran" class="px-7 py-3 rounded-full bg-white hover:bg-slate-50 text-darkEclipse text-xs font-bold border border-darkEclipse transition">
                    Pelajari Alur Layanan
                </a>
            </div>

            <!-- phone + rings + 4 floating cards -->
            <div class="mt-14 max-w-4xl mx-auto relative flex items-center justify-center min-h-[460px]">

                <div class="absolute w-[360px] h-[360px] rounded-full border border-blue-200/60 pointer-events-none"></div>
                <div class="absolute w-[280px] h-[280px] rounded-full border border-blue-300/50 pointer-events-none"></div>
                <div class="absolute w-[200px] h-[200px] rounded-full border border-blue-400/40 pointer-events-none"></div>

                <!-- phone (contoh E-Tiket) -->
                <div class="relative z-10 w-64 rounded-3xl bg-cyberNavy p-4 text-white shadow-2xl border-2 border-electricBlue/40 space-y-4">
                    <div class="w-16 h-3 bg-darkEclipse rounded-full mx-auto"></div>

                    <div class="space-y-1 text-center pt-2">
                        <span class="text-[10px] font-bold text-electricBlue uppercase tracking-wider block">E-Tiket Resmi</span>
                        <h4 class="font-extrabold text-sm text-white">Contoh Acara Kampus</h4>
                        <p class="text-[10px] text-slate-400">Nama Mahasiswa • NPM</p>
                    </div>

                    <div class="bg-gradient-to-r from-electricBlue to-blue-600 p-3 rounded-2xl text-center shadow-lg">
                        <span class="text-[11px] font-extrabold text-white"><i class="fa-solid fa-check"></i> TIKET VALID & TERVERIFIKASI</span>
                    </div>

                    <div class="bg-white p-3 rounded-2xl text-center space-y-1.5">
                        <svg viewBox="0 0 21 21" class="w-20 h-20 mx-auto text-darkEclipse" shape-rendering="crispEdges" aria-hidden="true">
                            <path fill="currentColor" d="M0 0h1v1h-1zM1 0h1v1h-1zM2 0h1v1h-1zM3 0h1v1h-1zM4 0h1v1h-1zM5 0h1v1h-1zM6 0h1v1h-1zM8 0h1v1h-1zM9 0h1v1h-1zM11 0h1v1h-1zM14 0h1v1h-1zM15 0h1v1h-1zM16 0h1v1h-1zM17 0h1v1h-1zM18 0h1v1h-1zM19 0h1v1h-1zM20 0h1v1h-1zM0 1h1v1h-1zM6 1h1v1h-1zM8 1h1v1h-1zM9 1h1v1h-1zM11 1h1v1h-1zM12 1h1v1h-1zM14 1h1v1h-1zM20 1h1v1h-1zM0 2h1v1h-1zM2 2h1v1h-1zM3 2h1v1h-1zM4 2h1v1h-1zM6 2h1v1h-1zM8 2h1v1h-1zM9 2h1v1h-1zM10 2h1v1h-1zM12 2h1v1h-1zM14 2h1v1h-1zM16 2h1v1h-1zM17 2h1v1h-1zM18 2h1v1h-1zM20 2h1v1h-1zM0 3h1v1h-1zM2 3h1v1h-1zM3 3h1v1h-1zM4 3h1v1h-1zM6 3h1v1h-1zM8 3h1v1h-1zM12 3h1v1h-1zM14 3h1v1h-1zM16 3h1v1h-1zM17 3h1v1h-1zM18 3h1v1h-1zM20 3h1v1h-1zM0 4h1v1h-1zM2 4h1v1h-1zM3 4h1v1h-1zM4 4h1v1h-1zM6 4h1v1h-1zM9 4h1v1h-1zM11 4h1v1h-1zM12 4h1v1h-1zM14 4h1v1h-1zM16 4h1v1h-1zM17 4h1v1h-1zM18 4h1v1h-1zM20 4h1v1h-1zM0 5h1v1h-1zM6 5h1v1h-1zM8 5h1v1h-1zM9 5h1v1h-1zM11 5h1v1h-1zM14 5h1v1h-1zM20 5h1v1h-1zM0 6h1v1h-1zM1 6h1v1h-1zM2 6h1v1h-1zM3 6h1v1h-1zM4 6h1v1h-1zM5 6h1v1h-1zM6 6h1v1h-1zM9 6h1v1h-1zM11 6h1v1h-1zM12 6h1v1h-1zM14 6h1v1h-1zM15 6h1v1h-1zM16 6h1v1h-1zM17 6h1v1h-1zM18 6h1v1h-1zM19 6h1v1h-1zM20 6h1v1h-1zM8 7h1v1h-1zM10 7h1v1h-1zM11 7h1v1h-1zM0 8h1v1h-1zM1 8h1v1h-1zM4 8h1v1h-1zM9 8h1v1h-1zM11 8h1v1h-1zM12 8h1v1h-1zM14 8h1v1h-1zM15 8h1v1h-1zM16 8h1v1h-1zM0 9h1v1h-1zM4 9h1v1h-1zM7 9h1v1h-1zM9 9h1v1h-1zM14 9h1v1h-1zM15 9h1v1h-1zM17 9h1v1h-1zM18 9h1v1h-1zM19 9h1v1h-1zM20 9h1v1h-1zM0 10h1v1h-1zM2 10h1v1h-1zM3 10h1v1h-1zM4 10h1v1h-1zM6 10h1v1h-1zM7 10h1v1h-1zM12 10h1v1h-1zM13 10h1v1h-1zM14 10h1v1h-1zM17 10h1v1h-1zM18 10h1v1h-1zM19 10h1v1h-1zM20 10h1v1h-1zM0 11h1v1h-1zM2 11h1v1h-1zM3 11h1v1h-1zM4 11h1v1h-1zM5 11h1v1h-1zM12 11h1v1h-1zM17 11h1v1h-1zM18 11h1v1h-1zM19 11h1v1h-1zM0 12h1v1h-1zM1 12h1v1h-1zM2 12h1v1h-1zM3 12h1v1h-1zM4 12h1v1h-1zM5 12h1v1h-1zM6 12h1v1h-1zM7 12h1v1h-1zM8 12h1v1h-1zM9 12h1v1h-1zM10 12h1v1h-1zM13 12h1v1h-1zM14 12h1v1h-1zM15 12h1v1h-1zM16 12h1v1h-1zM17 12h1v1h-1zM20 12h1v1h-1zM8 13h1v1h-1zM9 13h1v1h-1zM10 13h1v1h-1zM11 13h1v1h-1zM12 13h1v1h-1zM14 13h1v1h-1zM15 13h1v1h-1zM18 13h1v1h-1zM20 13h1v1h-1zM0 14h1v1h-1zM1 14h1v1h-1zM2 14h1v1h-1zM3 14h1v1h-1zM4 14h1v1h-1zM5 14h1v1h-1zM6 14h1v1h-1zM12 14h1v1h-1zM13 14h1v1h-1zM14 14h1v1h-1zM18 14h1v1h-1zM19 14h1v1h-1zM0 15h1v1h-1zM6 15h1v1h-1zM13 15h1v1h-1zM15 15h1v1h-1zM16 15h1v1h-1zM17 15h1v1h-1zM18 15h1v1h-1zM19 15h1v1h-1zM0 16h1v1h-1zM2 16h1v1h-1zM3 16h1v1h-1zM4 16h1v1h-1zM6 16h1v1h-1zM9 16h1v1h-1zM13 16h1v1h-1zM14 16h1v1h-1zM15 16h1v1h-1zM16 16h1v1h-1zM17 16h1v1h-1zM0 17h1v1h-1zM2 17h1v1h-1zM3 17h1v1h-1zM4 17h1v1h-1zM6 17h1v1h-1zM8 17h1v1h-1zM11 17h1v1h-1zM16 17h1v1h-1zM17 17h1v1h-1zM19 17h1v1h-1zM0 18h1v1h-1zM2 18h1v1h-1zM3 18h1v1h-1zM4 18h1v1h-1zM6 18h1v1h-1zM9 18h1v1h-1zM10 18h1v1h-1zM13 18h1v1h-1zM14 18h1v1h-1zM15 18h1v1h-1zM18 18h1v1h-1zM0 19h1v1h-1zM6 19h1v1h-1zM9 19h1v1h-1zM11 19h1v1h-1zM12 19h1v1h-1zM17 19h1v1h-1zM20 19h1v1h-1zM0 20h1v1h-1zM1 20h1v1h-1zM2 20h1v1h-1zM3 20h1v1h-1zM4 20h1v1h-1zM5 20h1v1h-1zM6 20h1v1h-1zM8 20h1v1h-1zM9 20h1v1h-1zM10 20h1v1h-1zM12 20h1v1h-1zM13 20h1v1h-1zM14 20h1v1h-1zM16 20h1v1h-1zM17 20h1v1h-1zM20 20h1v1h-1z"/>
                        </svg>
                        <span class="text-[10px] font-bold text-slate-700 block">Tunjukkan ke Panitia</span>
                    </div>
                </div>

                <!-- Langkah 1 (kiri atas) -->
                <div class="floaty absolute -left-2 top-4 hidden sm:flex items-center gap-3 bg-cream p-4 rounded-2xl border border-warm shadow-md">
                    <div>
                        <p class="text-base font-black text-darkEclipse">Temukan Acara</p>
                        <p class="text-[11px] font-semibold text-slate-700">Semua kegiatan ormawa dalam satu katalog</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center text-sm font-extrabold text-darkEclipse shadow-sm">1</div>
                </div>

                <!-- Langkah 4 (kiri bawah) -->
                <div class="floaty-2 absolute -left-6 bottom-6 hidden sm:flex items-center gap-3 bg-white p-3.5 rounded-2xl border border-slate-200/90 shadow-lg max-w-xs">
                    <div class="w-10 h-10 rounded-xl bg-amber text-darkEclipse flex items-center justify-center font-extrabold text-sm shrink-0">4</div>
                    <div class="min-w-0 pr-2">
                        <p class="text-xs font-bold text-darkEclipse">Check-in di Lokasi</p>
                        <p class="text-[10px] text-slate-500">Tunjukkan QR, panitia scan, selesai</p>
                    </div>
                </div>

                <!-- Langkah 2 (kanan atas) -->
                <div class="floaty-2 absolute -right-2 top-2 hidden sm:flex items-center gap-3 bg-white p-3.5 rounded-2xl border border-slate-200/90 shadow-lg max-w-xs">
                    <div class="w-12 h-12 rounded-xl bg-electricBlue text-white flex items-center justify-center font-extrabold text-base shrink-0">2</div>
                    <div>
                        <p class="text-xs font-bold text-darkEclipse">Daftar 1-Klik</p>
                        <p class="text-[10px] text-slate-500">Data NPM dan prodi terisi otomatis</p>
                    </div>
                </div>

                <!-- Langkah 3 (kanan bawah) -->
                <div class="floaty absolute -right-6 bottom-8 hidden sm:flex items-center gap-3 bg-ripeMalinka text-white p-4 rounded-2xl shadow-lg glow-coral">
                    <div>
                        <p class="text-base font-black text-white">Terima E-Tiket</p>
                        <p class="text-[11px] font-medium text-rose-100">QR Code terbit setelah dikonfirmasi</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-sm font-extrabold">3</div>
                </div>
            </div>

            <!-- trust bar -->
            <div class="mt-12 pt-8 border-t border-slate-200/80 max-w-4xl mx-auto text-center space-y-4">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Dipakai oleh berbagai unsur organisasi kampus</span>
                <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-3 text-slate-400 font-extrabold text-sm sm:text-base">
                    <span class="hover:text-darkEclipse transition">BEM</span>
                    <span class="hover:text-darkEclipse transition">HIMPUNAN</span>
                    <span class="hover:text-darkEclipse transition">UKM</span>
                    <span class="hover:text-darkEclipse transition">DPM</span>
                    <span class="hover:text-darkEclipse transition">KOMUNITAS</span>
                </div>
            </div>
        </section>

        <!-- katalog acara -->
        <section id="agenda" class="bg-surface py-16 sm:py-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-ripeMalinka block mb-1">Agenda Terkini</span>
                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-darkEclipse">Katalog Acara Pilihan</h2>
                    </div>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-electricBlue hover:underline shrink-0">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse (($events ?? collect()) as $event)
                    @php
                        $chip = [
                            'bg-electricBlue/15 text-electricBlue',
                            'bg-ripeMalinka/15 text-ripeMalinka',
                            'bg-cream text-darkEclipse',
                        ][$loop->index % 3];
                    @endphp
                    <div class="bg-white p-5 rounded-2xl border border-warm shadow-sm hover:border-electricBlue transition duration-200 flex flex-col justify-between gap-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-md {{ $chip }}">{{ $event->category->name ?? 'Acara' }}</span>
                                @if($event->isPaid())
                                <span class="text-[11px] font-extrabold text-darkEclipse">Rp {{ number_format((float) $event->price, 0, ',', '.') }}</span>
                                @else
                                <span class="text-[11px] font-extrabold text-emerald-600">GRATIS</span>
                                @endif
                            </div>
                            <h3 class="mt-3 font-extrabold text-sm text-darkEclipse leading-snug">{{ $event->title }}</h3>
                            <div class="mt-2 space-y-1 text-xs text-slate-500">
                                <div><i class="fa-regular fa-calendar mr-2 text-ripeMalinka"></i>{{ $event->start_date->translatedFormat('l, d M Y') }}</div>
                                <div><i class="fa-solid fa-location-dot mr-2 text-darkEclipse"></i>{{ \Illuminate\Support\Str::limit($event->location, 40) }}</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="block text-center w-full py-2.5 rounded-full bg-electricBlue hover:bg-[#187bcd] text-white text-xs font-bold transition shadow-sm glow-blue">
                            Lihat Detail →
                        </a>
                    </div>
                    @empty
                    <div class="md:col-span-3 bg-white border border-dashed border-warm rounded-2xl p-10 text-center text-sm text-slate-500">
                        Belum ada acara yang dipublikasikan. Cek lagi sebentar lagi ya!
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- peran -->
        <section id="peran" class="bg-white border-y border-warm py-16 sm:py-24">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-14">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-ripeMalinka mb-2 block">Dua Sisi Kolaborasi</span>
                    <h2 class="text-3xl sm:text-4xl font-black text-darkEclipse tracking-tight">Dirancang untuk Mahasiswa & Ormawa</h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-3">Dua alur kerja terintegrasi yang memudahkan partisipasi maupun pengelolaan acara kampus.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">

                    <div class="bg-surface rounded-3xl p-8 border border-warm space-y-6">
                        <div class="w-12 h-12 rounded-2xl bg-electricBlue/15 text-electricBlue flex items-center justify-center text-xl">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-white bg-darkEclipse px-3 py-1 rounded-full inline-block mb-3">Untuk Mahasiswa</span>
                            <h3 class="text-2xl font-extrabold text-darkEclipse tracking-tight">Kemudahan Eksplorasi & Tiket Digital</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mt-2">Akses terpusat ke seluruh kegiatan kampus tanpa harus mengecek puluhan poster di mading atau grup percakapan.</p>
                        </div>
                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 border-t border-warm pt-5">
                            <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check text-electricBlue mt-0.5 text-base"></i><span><strong class="text-darkEclipse">Pendaftaran 1-Klik:</strong> Terhubung otomatis dengan data diri mahasiswa (NPM, Program Studi, Semester).</span></li>
                            <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check text-electricBlue mt-0.5 text-base"></i><span><strong class="text-darkEclipse">E-Ticket Bebas Kertas:</strong> Simpan tiket di smartphone atau unduh PDF untuk presensi instan di lokasi.</span></li>
                            <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check text-electricBlue mt-0.5 text-base"></i><span><strong class="text-darkEclipse">Profil Mahasiswa Terpusat:</strong> Update kontak WhatsApp dan kelola riwayat kepesertaan acara kapan saja.</span></li>
                        </ul>
                    </div>

                    <div class="bg-surface rounded-3xl p-8 border border-warm space-y-6">
                        <div class="w-12 h-12 rounded-2xl bg-ripeMalinka/15 text-ripeMalinka flex items-center justify-center text-xl">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-white bg-ripeMalinka px-3 py-1 rounded-full inline-block mb-3">Untuk Penyelenggara</span>
                            <h3 class="text-2xl font-extrabold text-darkEclipse tracking-tight">Manajemen Peserta & Publikasi Terpusat</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mt-2">Wadah resmi bagi BEM, Himpunan Mahasiswa, dan UKM untuk mengumumkan kegiatan serta merekap peserta secara akurat.</p>
                        </div>
                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 border-t border-warm pt-5">
                            <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check text-ripeMalinka mt-0.5 text-base"></i><span><strong class="text-darkEclipse">Publikasi Acara Cepat:</strong> Terbitkan info seminar, workshop, dan kompetisi dengan format terstandarisasi.</span></li>
                            <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check text-ripeMalinka mt-0.5 text-base"></i><span><strong class="text-darkEclipse">Rekapitulasi Valid:</strong> Hindari data ganda karena pendaftar terverifikasi dengan data akun kampus resmi.</span></li>
                            <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check text-ripeMalinka mt-0.5 text-base"></i><span><strong class="text-darkEclipse">Dashboard Penyelenggara:</strong> Pantau kuota peserta dan koordinasi kehadiran dengan efisien.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- fitur -->
        <section id="fitur" class="py-16 sm:py-24 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center mb-14">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-electricBlue mb-2 block">Fitur Inti</span>
                <h2 class="text-3xl sm:text-4xl font-black text-darkEclipse tracking-tight">Teknologi Praktis untuk Ekosistem Kampus</h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3">Menyederhanakan administrasi kegiatan agar panitia dan mahasiswa fokus pada substansi acara.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-7 rounded-2xl border border-warm shadow-sm hover:border-electricBlue transition duration-200 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-electricBlue/15 text-electricBlue flex items-center justify-center text-lg"><i class="fa-solid fa-compass"></i></div>
                    <h3 class="text-base font-extrabold text-darkEclipse">Katalog Acara Terpadu</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pencarian cepat berdasarkan bidang minat: teknologi informasi, kewirausahaan, seni budaya, riset ilmiah, hingga kepanitiaan.</p>
                </div>
                <div class="bg-white p-7 rounded-2xl border border-warm shadow-sm hover:border-ripeMalinka transition duration-200 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-ripeMalinka/15 text-ripeMalinka flex items-center justify-center text-lg"><i class="fa-solid fa-ticket"></i></div>
                    <h3 class="text-base font-extrabold text-darkEclipse">Tiket & Presensi Digital</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">E-ticket terbit otomatis begitu pendaftaran dikonfirmasi, lengkap dengan QR Code untuk validasi kehadiran di pintu masuk.</p>
                </div>
                <div class="bg-white p-7 rounded-2xl border border-warm shadow-sm hover:border-amber transition duration-200 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-cream text-amberDark flex items-center justify-center text-lg"><i class="fa-regular fa-id-card"></i></div>
                    <h3 class="text-base font-extrabold text-darkEclipse">Profil Mahasiswa Mandiri</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Kelola data diri, NPM, jurusan, semester, nomor kontak, serta foto profil secara mandiri dan aman.</p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section id="tentang" class="px-4 sm:px-6 lg:px-8 pb-16 sm:pb-24">
            <div class="max-w-6xl mx-auto bg-darkEclipse text-white rounded-3xl px-8 sm:px-12 py-12 sm:py-14 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
                <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full border border-electricBlue/30 pointer-events-none"></div>
                <div class="absolute -right-6 -top-6 w-44 h-44 rounded-full border border-electricBlue/20 pointer-events-none"></div>
                <div class="space-y-3 text-center md:text-left max-w-xl relative">
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight">Siap mengeksplorasi kegiatan kampus?</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Bergabunglah bersama mahasiswa dan organisasi kampus yang telah memanfaatkan ekosistem digital Univents.</p>
                </div>
                <div class="relative">
                    @auth
                    <a href="{{ Auth::user()->role === 'student' ? route('profile.show') : (Auth::user()->role === 'organizer' ? route('organisasi.dashboard') : route('admin.dashboard')) }}" class="inline-block px-8 py-3.5 rounded-full text-sm font-bold bg-electricBlue text-white hover:bg-[#187bcd] transition shadow-md glow-blue">
                        {{ Auth::user()->role === 'student' ? 'Buka Profil Saya' : 'Buka Dashboard' }}
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="inline-block px-8 py-3.5 rounded-full text-sm font-bold bg-electricBlue text-white hover:bg-[#187bcd] transition shadow-md glow-blue">
                        Daftar Akun Baru
                    </a>
                    @endauth
                </div>
            </div>
        </section>

    </main>

    <footer id="tentang" class="bg-darkEclipse text-white scroll-mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <div class="space-y-3">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5">
                        <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                        <span class="text-xl font-extrabold tracking-tight">Uni<span class="text-electricBlue">vents</span></span>
                    </a>
                    <p class="text-xs text-slate-300 leading-relaxed max-w-xs">
                        Platform terintegrasi untuk menemukan, mendaftar, dan mengelola kegiatan kampus bagi mahasiswa dan organisasi mahasiswa.
                    </p>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-electricBlue mb-3">Jelajahi</h4>
                    <ul class="grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-slate-300">
                        <li><a href="#agenda" class="hover:text-electricBlue transition">Agenda Acara</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-electricBlue transition">Katalog Acara</a></li>
                        <li><a href="#peran" class="hover:text-electricBlue transition">Untuk Siapa</a></li>
                        <li><a href="#fitur" class="hover:text-electricBlue transition">Fitur Platform</a></li>
                        @guest
                        <li><a href="{{ route('login') }}" class="hover:text-electricBlue transition">Masuk</a></li>
                        @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="hover:text-electricBlue transition">Daftar Akun</a></li>
                        @endif
                        @endguest
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-electricBlue mb-3">Tentang Platform</h4>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-ticket w-4 text-ripeMalinka"></i>Pendaftaran acara &amp; e-tiket digital</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-bookmark w-4 text-amber"></i>Simpan acara favoritmu</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check w-4 text-electricBlue"></i>Tiket terverifikasi dengan QR Code</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-users-gear w-4 text-ripeMalinka"></i>Dashboard untuk penyelenggara acara</li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
                <span>&copy; {{ date('Y') }} Univents Kampus. Hak cipta dilindungi.</span>
                <span>Platform Terintegrasi Mahasiswa &amp; Ormawa</span>
            </div>
        </div>
    </footer>
</body>

</html>