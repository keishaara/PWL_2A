<header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button type="button" onclick="toggleStudentSidebar()" aria-label="Buka menu" class="md:hidden w-9 h-9 -ml-1 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center border border-white/10 transition">
                <i class="fa-solid fa-bars"></i>
            </button>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain">
                <span class="text-xl font-extrabold tracking-tight text-white">Uni<span class="text-[#1E90FF]">vents</span></span>
            </a>
            <span class="hidden sm:inline-block ml-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#1E90FF]/20 text-[#1E90FF] border border-[#1E90FF]/30 uppercase tracking-wider">Mahasiswa</span>
            @if(isset($title) && $title)
            <div class="hidden sm:block h-5 w-[1px] bg-white/20 ml-2"></div>
            <span class="hidden sm:inline-block text-xs font-semibold text-[#1E90FF]">{{ $title }}</span>
            @endif
        </div>

        @php
        $recentNotifications = Auth::check() ? Auth::user()->inAppNotifications()->latest()->take(5)->get() : collect();
        $unreadNotifications = Auth::check() ? Auth::user()->inAppNotifications()->where('is_read', false)->count() : 0;
        @endphp
        <div class="flex items-center gap-4">
            @auth
            {{-- Kalau sudah login, tampilkan lonceng notifikasi & profil --}}
            <details class="relative">
                ... (tetap seperti aslinya) ...
            </details>
            <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 text-xs font-semibold text-white/90 hover:text-white transition">
                <div class="w-8 h-8 rounded-full bg-[#1E90FF]/20 border border-[#1E90FF]/50 flex items-center justify-center text-[#1E90FF] font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="hidden md:inline font-medium text-white">{{ Auth::user()->name }}</span>
            </a>
            @else
            {{-- Kalau belum login (tamu), tampilkan tombol Masuk / Daftar --}}
            <a href="{{ route('login') }}" class="text-xs font-bold text-white hover:text-[#1E90FF] transition">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-[#1E90FF] hover:bg-blue-600 text-white transition shadow-sm">
                Daftar
            </a>
            @endauth
        </div>
    </div>
</header>

@include('partials.idle-timeout')