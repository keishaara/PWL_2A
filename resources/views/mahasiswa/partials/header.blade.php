@php
    $links = [
        'dashboard' => ['Dashboard', route('dashboard')],
        'events'    => ['Jelajah Acara', route('events.index')],
        'tickets'   => ['Tiket Saya', route('tickets.index')],
        'bookmarks' => ['Tersimpan', route('bookmarks.index')],
        'payments'  => ['Status Pembayaran', route('payments.index')],
    ];
@endphp
<header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                <span class="text-xl font-extrabold tracking-tight text-white hidden sm:inline">Uni<span class="text-brand-cyan">vents</span></span>
            </a>
            <div class="hidden sm:block h-5 w-[1px] bg-white/20"></div>
            <nav class="hidden sm:flex items-center gap-4 text-xs font-semibold text-white/80">
                @foreach ($links as $key => [$label, $url])
                    <a href="{{ $url }}" class="{{ ($active ?? '') === $key ? 'text-brand-coral font-bold' : 'hover:text-brand-cyan' }} transition">{{ $label }}</a>
                @endforeach
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
    <nav class="sm:hidden flex gap-4 overflow-x-auto px-4 pb-2 text-xs font-semibold text-white/80">
        @foreach ($links as $key => [$label, $url])
            <a href="{{ $url }}" class="whitespace-nowrap {{ ($active ?? '') === $key ? 'text-brand-coral font-bold' : '' }}">{{ $label }}</a>
        @endforeach
    </nav>
</header>