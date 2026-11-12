<header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-5">
            <button type="button" onclick="toggleStudentSidebar()" aria-label="Buka menu" class="md:hidden w-9 h-9 -ml-1 -mr-2 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center border border-white/10 transition">
                <i class="fa-solid fa-bars"></i>
            </button>
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-7 w-auto object-contain">
                <span class="text-xl font-extrabold tracking-tight text-white">Uni<span class="text-brand-cyan">vents</span></span>
            </a>

            <div class="hidden sm:block h-5 w-[1px] bg-white/20"></div>

            <nav class="hidden sm:flex items-center gap-4 text-xs font-semibold text-white/80">
                <span class="text-brand-cyan">{{ $title ?? '' }}</span>
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