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

        @php
            $recentNotifications = Auth::user()->inAppNotifications()->latest()->take(5)->get();
            $unreadNotifications = Auth::user()->inAppNotifications()->where('is_read', false)->count();
        @endphp
        <div class="flex items-center gap-4">
            <details class="relative">
                <summary class="relative list-none cursor-pointer w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center" aria-label="Notifikasi">
                    <i class="fa-solid fa-bell"></i>
                    @if ($unreadNotifications)
                        <span class="absolute -top-1 -right-1 min-w-4 h-4 px-1 rounded-full bg-brand-coral text-[9px] font-bold text-white flex items-center justify-center">{{ $unreadNotifications }}</span>
                    @endif
                </summary>
                <div class="absolute right-0 mt-3 w-80 max-w-[calc(100vw-2rem)] bg-white rounded-xl border border-slate-200 shadow-xl p-3 text-brand-navy">
                    <h2 class="px-2 py-1 text-xs font-extrabold">Notifikasi</h2>
                    @forelse ($recentNotifications as $notification)
                        <div class="p-2 rounded-lg {{ $notification->is_read ? '' : 'bg-cyan-50' }}">
                            <p class="text-xs font-bold">{{ $notification->title }}</p>
                            <p class="text-[11px] text-slate-600 mt-1">{{ $notification->message }}</p>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-[10px] text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                                @unless ($notification->is_read)
                                    <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                        @csrf
                                        <button class="text-[10px] font-bold text-brand-navy hover:underline">Tandai dibaca</button>
                                    </form>
                                @endunless
                            </div>
                        </div>
                    @empty
                        <p class="p-2 text-xs text-slate-500">Belum ada notifikasi.</p>
                    @endforelse
                </div>
            </details>
            <a href="{{ route('profile.show') }}" class="flex items-center gap-2 text-xs font-semibold text-white/90 hover:text-white transition">
                <div class="w-7 h-7 rounded-full bg-brand-cyan/20 border border-brand-cyan flex items-center justify-center text-brand-cyan font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
            </a>
        </div>
    </div>
</header>