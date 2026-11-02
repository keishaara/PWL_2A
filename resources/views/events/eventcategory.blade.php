<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Acara - Univents</title>

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

                <nav class="hidden sm:flex items-center gap-3 text-xs font-semibold text-white/80">
                    <!-- <a href="{{ route('dashboard') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                    <span class="text-white/30">/</span> -->
                    <span class="text-brand-cyan">Katalog Acara</span>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <span class="hidden md:inline text-xs font-semibold text-white/80">
                        {{ Auth::user()->name }}
                    </span>
                @endauth
                <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-white/10 text-white hover:bg-brand-coral transition border border-white/10">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
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

                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold bg-brand-navy text-white shadow-sm transition">
                    <i class="fa-solid fa-compass w-4 text-center text-brand-cyan"></i>
                    <span>Katalog Acara</span>
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
                <h4 class="text-xs font-bold text-brand-cyan uppercase tracking-wider mb-1">Univents Katalog</h4>
                <p class="text-[11px] text-slate-300 leading-relaxed">
                    Cari acara kampus berdasarkan kata kunci atau pilih kategori yang sesuai minatmu.
                </p>
            </div>
        </aside>

        <main class="flex-1 space-y-6">

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <form action="{{ route('events.index') }}" method="GET" class="flex items-center gap-3">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <div class="flex items-center flex-1 px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-400 focus-within:border-brand-navy focus-within:bg-white transition">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 mr-3 text-sm"></i>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari nama acara, topik, atau lokasi..."
                            class="w-full bg-transparent text-brand-navy text-sm outline-none placeholder:text-slate-400"
                        >
                    </div>

                    <button type="submit" class="px-5 py-3 rounded-xl bg-brand-coral text-white text-xs font-bold hover:bg-[#e04d59] transition shadow-md shadow-brand-coral/25 shrink-0">
                        Cari
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold scrollbar-none">
                <a
                    href="{{ route('events.index', array_filter(['q' => request('q')])) }}"
                    class="px-4 py-2 rounded-full border transition whitespace-nowrap {{ !request('category') ? 'bg-brand-navy text-white border-brand-navy' : 'bg-white text-slate-600 border-slate-200 hover:border-brand-navy' }}"
                >
                    Semua Acara
                </a>

                @foreach ($categories as $cat)
                    <a
                        href="{{ route('events.index', array_filter(['category' => $cat->slug, 'q' => request('q')])) }}"
                        class="px-4 py-2 rounded-full border transition whitespace-nowrap {{ request('category') == $cat->slug ? 'bg-brand-navy text-white border-brand-navy' : 'bg-white text-slate-600 border-slate-200 hover:border-brand-navy' }}"
                    >
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-brand-navy">Daftar Kegiatan Tersedia</h2>
                    <p class="text-xs text-slate-500">Menampilkan {{ $events->total() }} acara aktif</p>
                </div>

                @if(request('q') || request('category'))
                    <a href="{{ route('events.index') }}" class="text-xs text-brand-coral font-bold hover:underline">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Reset Filter
                    </a>
                @endif
            </div>

            @if ($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($events as $event)
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-brand-cyan transition duration-300 overflow-hidden flex flex-col justify-between group">

                            <div>
                                <div class="relative h-40 w-full overflow-hidden bg-slate-100">
                                    <img
                                        src="{{ $event->banner ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600' }}"
                                        alt="{{ $event->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    >
                                    <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-brand-navy/90 text-white backdrop-blur-sm">
                                        {{ $event->category->name }}
                                    </span>

                                    <span class="absolute bottom-2.5 right-2.5 px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/95 shadow-sm {{ $event->isPaid() ? 'text-brand-coral' : 'text-emerald-600' }}">
                                        @if($event->isPaid())
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        @else
                                            GRATIS
                                        @endif
                                    </span>
                                </div>

                                <div class="p-4 space-y-2">
                                    <div class="flex items-center gap-1.5 text-[11px] text-brand-cyan font-bold">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ $event->start_date->translatedFormat('d M Y, H:i') }} WIB</span>
                                    </div>

                                    <h3 class="text-sm font-bold text-brand-navy line-clamp-2 leading-snug group-hover:text-brand-coral transition">
                                        <a href="{{ route('events.show', $event->slug) }}">
                                            {{ $event->title }}
                                        </a>
                                    </h3>

                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ $event->description }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-4 pt-0">
                                <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="h-6 w-6 rounded-full bg-brand-navy text-white text-[10px] flex items-center justify-center font-bold">
                                            {{ substr($event->organization->name, 0, 1) }}
                                        </span>
                                        <span class="text-xs text-slate-600 font-medium truncate max-w-[120px]">
                                            {{ $event->organization->name }}
                                        </span>
                                    </div>

                                    <a
                                        href="{{ route('events.show', $event->slug) }}"
                                        class="px-3 py-1.5 rounded-lg bg-brand-navy text-white text-xs font-semibold hover:bg-brand-coral transition"
                                    >
                                        Detail
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            @else

                <div class="text-center py-14 bg-white rounded-2xl border border-dashed border-slate-300">
                    <div class="h-14 w-14 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-xl">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700">Acara Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Coba gunakan kata kunci lain atau ubah pilihan kategori.
                    </p>
                    <a href="{{ route('events.index') }}" class="inline-block mt-3 text-xs font-bold text-brand-coral hover:underline">
                        Lihat Semua Acara
                    </a>
                </div>
            @endif

        </main>

    </div>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Univents Kampus &bull; Platform Terintegrasi Mahasiswa & Ormawa
    </footer>

</body>
</html>