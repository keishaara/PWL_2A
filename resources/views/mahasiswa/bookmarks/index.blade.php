<!DOCTYPE html>
<html lang="id">
<head>
    @include('mahasiswa.partials.head')
    <title>Event Tersimpan - Univents</title>
</head>
<body class="bg-brand-bg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('mahasiswa.partials.header', ['active' => 'bookmarks'])

    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <div class="mb-8">
            <span class="text-xs font-bold text-brand-coral uppercase tracking-wider block mb-1">Wishlist</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-navy">Event Tersimpan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Acara yang kamu tandai untuk diikuti nanti.</p>
        </div>

        @if (session('bookmark'))
            <div class="mb-6 p-4 rounded-xl bg-brand-amber/20 border border-brand-amber text-[#8F6800] text-xs sm:text-sm flex items-center gap-3">
                <i class="fa-solid fa-bookmark text-lg"></i><div>{{ session('bookmark') }}</div>
            </div>
        @endif

        @if ($events->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col group hover:border-brand-cyan transition">
                        <div class="relative h-40 overflow-hidden bg-slate-100">
                            <img src="{{ $event->banner ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600' }}"
                                 alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-brand-navy/90 text-white">{{ $event->category->name }}</span>
                            <span class="absolute bottom-2.5 right-2.5 px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/95 shadow-sm {{ $event->isPaid() ? 'text-brand-coral' : 'text-[#0F685B]' }}">
                                {{ $event->isPaid() ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'GRATIS' }}
                            </span>
                        </div>

                        <div class="p-4 space-y-2 flex-1">
                            <div class="flex items-center gap-1.5 text-[11px] text-[#0F685B] font-bold">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ $event->start_date->translatedFormat('d M Y, H:i') }} WIB</span>
                            </div>
                            <h3 class="text-sm font-bold text-brand-navy line-clamp-2 leading-snug">
                                <a href="{{ route('events.show', $event->slug) }}" class="hover:text-brand-coral transition">{{ $event->title }}</a>
                            </h3>
                            <p class="text-[11px] text-slate-500"><i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}</p>
                            <p class="text-[11px] text-slate-500"><i class="fa-solid fa-people-group mr-1 text-[#8F6800]"></i>{{ $event->organization->name }}</p>
                        </div>

                        <div class="p-4 pt-0 flex items-center gap-2">
                            <a href="{{ route('events.show', $event->slug) }}" class="flex-1 text-center px-3 py-2 rounded-lg bg-brand-navy text-white text-xs font-semibold hover:bg-brand-coral transition">Detail</a>
                            <form action="{{ route('events.bookmark', $event->slug) }}" method="POST">
                                @csrf
                                <button type="submit" title="Hapus dari tersimpan"
                                        class="px-3 py-2 rounded-lg border border-brand-coral/40 text-brand-coral text-xs font-semibold hover:bg-brand-coral/10 transition">
                                    <i class="fa-solid fa-bookmark"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $events->links() }}</div>
        @else
            <div class="text-center py-14 bg-white rounded-2xl border border-dashed border-slate-300">
                <div class="h-14 w-14 mx-auto mb-4 rounded-full bg-brand-amber/30 flex items-center justify-center text-[#8F6800] text-xl">
                    <i class="fa-regular fa-bookmark"></i>
                </div>
                <h3 class="text-sm font-bold text-brand-navy">Belum Ada Acara Tersimpan</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Klik ikon bookmark pada acara yang menarik untuk menyimpannya di sini.</p>
                <a href="{{ route('events.index') }}" class="inline-block mt-3 text-xs font-bold text-brand-coral hover:underline">Jelajahi Acara</a>
            </div>
        @endif
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Univents Kampus
    </footer>
</body>
</html>