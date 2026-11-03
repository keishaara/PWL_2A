<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Univents</title>

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
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight text-white hidden sm:inline">Uni<span class="text-brand-cyan">vents</span></span>
                </a>

                <div class="hidden sm:block h-5 w-[1px] bg-white/20"></div>

                <nav class="hidden sm:flex items-center gap-4 text-xs font-semibold text-white/80">
                    <span class="text-brand-cyan">Dashboard Mahasiswa</span>
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

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold bg-brand-navy text-white shadow-sm transition">
                    <i class="fa-solid fa-house w-4 text-center text-brand-cyan"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy transition">
                    <i class="fa-solid fa-compass w-4 text-center"></i>
                    <span>Katalog Acara</span>
                </a>

                <a href="{{ route('payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy transition">
                    <i class="fa-solid fa-receipt w-4 text-center"></i>
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


        <main class="flex-1 space-y-6">

            <div class="bg-brand-navy text-white rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-md">
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-brand-cyan/15 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-brand-coral/15 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-brand-cyan border border-white/15 mb-3">
                            🎓 Mahasiswa Aktif
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-slate-300 text-xs sm:text-sm mt-1.5 max-w-xl">
                            {{ Auth::user()->major ?? 'Program Studi Mahasiswa' }} &bull; NPM: {{ Auth::user()->npm ?? '-' }}
                        </p>
                    </div>

                    <a href="{{ route('events.index') }}" class="px-5 py-3 rounded-xl bg-brand-coral text-white text-xs sm:text-sm font-bold hover:bg-[#e04d59] transition shadow-lg shadow-brand-coral/30 inline-flex items-center justify-center gap-2 shrink-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Jelajahi Acara</span>
                    </a>
                </div>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500">Acara Tersedia</span>
                        <h3 class="text-2xl font-black text-brand-navy mt-1">{{ $totalEvents }}</h3>
                        <span class="text-[10px] font-bold text-brand-cyan bg-brand-navy px-2 py-0.5 rounded-full mt-1 inline-block">Siap Diikuti</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-brand-cyan/20 text-brand-navy flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500">Kategori Minat</span>
                        <h3 class="text-2xl font-black text-brand-navy mt-1">{{ $totalCategories }}</h3>
                        <span class="text-[10px] text-slate-400 mt-1 inline-block">Topik Kampus</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-brand-amber/30 text-brand-navy flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500">Kelengkapan Profil</span>
                        <h3 class="text-2xl font-black text-brand-navy mt-1">
                            {{ Auth::user()->npm && Auth::user()->major ? 'Lengkap' : 'Belum' }}
                        </h3>
                        <a href="{{ route('profile.show') }}" class="text-[10px] font-bold text-brand-coral hover:underline mt-1 inline-block">
                            Perbarui Data &rarr;
                        </a>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-brand-coral/20 text-brand-coral flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                </div>
            </div>


            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-brand-navy">Rekomendasi Kegiatan Kampus</h2>
                        <p class="text-xs text-slate-500">Acara yang akan berlangsung dalam waktu dekat.</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="text-xs font-bold text-brand-coral hover:underline flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @forelse ($events as $event)
                    <div class="rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between hover:border-brand-cyan transition duration-200 group bg-slate-50/50">
                        <div>
                            <div class="relative h-36 w-full overflow-hidden bg-slate-200">
                                <img src="{{ $event->banner ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500' }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-brand-navy/90 text-white">
                                    {{ $event->category->name }}
                                </span>
                            </div>
                            <div class="p-4 space-y-2">
                                <span class="text-[11px] font-bold text-brand-cyan block">
                                    <i class="fa-regular fa-calendar mr-1"></i> {{ $event->start_date->translatedFormat('d M Y') }}
                                </span>
                                <h4 class="font-bold text-sm text-brand-navy line-clamp-2 leading-snug">
                                    {{ $event->title }}
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-1">
                                    <i class="fa-solid fa-location-dot mr-1"></i> {{ $event->location }}
                                </p>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ route('events.show', $event->slug) }}" class="block text-center w-full py-2 rounded-xl text-xs font-bold bg-brand-navy text-white hover:bg-brand-coral transition">
                                Lihat Acara
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-10 text-slate-400 text-xs">
                        Belum ada acara yang tersedia saat ini.
                    </div>
                    @endforelse
                </div>
            </div>

        </main>

    </div>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Univents Kampus &bull; Platform Terintegrasi Mahasiswa & Ormawa
    </footer>

</body>

</html>