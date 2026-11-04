<!DOCTYPE html>
<html lang="id">

<head>
    @include('mahasiswa.partials.head')
    <title>E-Tiket Saya - Univents</title>
</head>

<body class="bg-brand-bg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('mahasiswa.partials.header', ['title' => 'E-Tiket Saya'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('mahasiswa.partials.sidebar', ['active' => 'tickets'])

        <main class="flex-1 min-w-0">

            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-bold text-brand-coral uppercase tracking-wider block mb-1">Tiket
                        Digital</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-navy">E-Tiket Saya</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Tunjukkan QR Code pada panitia saat check-in. Setiap tiket memiliki kode unik.
                    </p>
                </div>
                <a href="{{ route('events.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-navy text-white text-xs font-bold hover:bg-slate-800 transition shadow-sm">
                    <i class="fa-solid fa-compass"></i><span>Cari Acara Menarik</span>
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-xl bg-brand-cyan/15 border border-brand-cyan/40 text-[#0F685B] text-xs sm:text-sm">
                    {{ session('success') }}</div>
            @endif

            @if ($tickets->count())
                <div class="grid grid-cols-1 gap-5">
                    @foreach ($tickets as $ticket)
                        @php $event = $ticket->registration->event; @endphp
                        <div
                            class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col sm:flex-row">
                            <div class="p-5 flex-1 space-y-3 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span
                                        class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-brand-navy text-white">{{ $event->category->name }}</span>
                                    @if ($ticket->status === 'used')
                                        <span
                                            class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">Sudah
                                            Dipakai</span>
                                    @else
                                        <span
                                            class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-brand-cyan/15 text-[#0F685B] border border-brand-cyan/40">
                                            <i class="fa-solid fa-circle-check"></i> Aktif &bull; Terverifikasi
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-base font-extrabold text-brand-navy leading-snug">
                                    <a href="{{ route('events.show', $event->slug) }}"
                                        class="hover:text-brand-coral transition">{{ $event->title }}</a>
                                </h3>

                                <div class="space-y-1.5 text-xs text-slate-600">
                                    <div class="flex items-center gap-2"><i
                                            class="fa-regular fa-calendar w-4 text-brand-navy"></i>{{ $event->start_date->translatedFormat('l, d F Y') }}
                                    </div>
                                    <div class="flex items-center gap-2"><i
                                            class="fa-regular fa-clock w-4 text-brand-navy"></i>{{ $event->start_date->format('H:i') }}
                                        - {{ $event->end_date->format('H:i') }} WIB</div>
                                    <div class="flex items-start gap-2"><i
                                            class="fa-solid fa-location-dot w-4 text-brand-navy mt-0.5"></i><span>{{ $event->location }}</span>
                                    </div>
                                    <div class="flex items-center gap-2"><i
                                            class="fa-solid fa-people-group w-4 text-[#8F6800]"></i>{{ $event->organization->name }}
                                    </div>
                                </div>

                                <a href="{{ route('tickets.download', $ticket->ticket_code) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-coral text-white text-xs font-bold hover:bg-[#e04d59] transition shadow-sm">
                                    <i class="fa-solid fa-file-pdf"></i><span>Download PDF</span>
                                </a>
                            </div>

                            <div
                                class="sm:w-52 shrink-0 p-5 border-t sm:border-t-0 sm:border-l border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center text-center">
                                <img src="{{ $ticket->qr_data_uri }}" alt="QR Code {{ $ticket->ticket_code }}"
                                    class="w-36 h-36 rounded-lg bg-white border border-slate-200 p-1 {{ $ticket->status === 'used' ? 'opacity-40' : '' }}">
                                <span class="mt-2 text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Kode
                                    Tiket</span>
                                <span class="font-mono text-sm font-extrabold text-brand-navy">{{ $ticket->ticket_code }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $tickets->links() }}</div>
            @else
                <div class="text-center py-14 bg-white rounded-2xl border border-dashed border-slate-300">
                    <div
                        class="h-14 w-14 mx-auto mb-4 rounded-full bg-brand-amber/30 flex items-center justify-center text-[#8F6800] text-xl">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <h3 class="text-sm font-bold text-brand-navy">Belum Ada E-Tiket</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Tiket muncul setelah kamu mendaftar pada sebuah acara.
                    </p>
                    <a href="{{ route('events.index') }}"
                        class="inline-block mt-3 text-xs font-bold text-brand-coral hover:underline">Jelajahi Acara</a>
                </div>
            @endif
        </main>
    </div>

    @include('mahasiswa.partials.footer')
</body>

</html>