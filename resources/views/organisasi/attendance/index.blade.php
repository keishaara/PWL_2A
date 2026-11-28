<!DOCTYPE html>
<html lang="id">
<head>
    @include('organisasi.partials.head')
    <title>Presensi Hari-H - Penyelenggara Univents</title>
</head>
<body class="bg-brand-warmBg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('organisasi.partials.header', ['title' => 'Presensi Hari-H'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'attendance'])

        <main class="flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Presensi Acara Hari-H</h1>
                    <p class="text-xs text-slate-500 mt-1">Pilih acara untuk membuka meja presensi dan memvalidasi tiket masuk digital peserta.</p>
                </div>
            </div>

            @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @php
                $totalEvents = $events->total();
                $totalConfirmed = $events->sum('confirmed_registrations_count');
                $totalCheckedIn = $events->sum('checked_in_count');
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-brand-blue"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Acara Aktif</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $totalEvents }}</span>
                    <i class="fa-solid fa-calendar-check absolute right-4 bottom-3 text-slate-100 text-3xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-brand-cyan"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Peserta Terdaftar</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $totalConfirmed }}</span>
                    <i class="fa-solid fa-users absolute right-4 bottom-3 text-slate-100 text-3xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-emerald-500"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Peserta Hadir (Check-In)</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $totalCheckedIn }}</span>
                    <i class="fa-solid fa-qrcode absolute right-4 bottom-3 text-slate-100 text-3xl"></i>
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($events as $event)
                    @php
                        $confirmed = $event->confirmed_registrations_count ?? 0;
                        $checkedIn = $event->checked_in_count ?? 0;
                        $pct = $confirmed > 0 ? round(($checkedIn / $confirmed) * 100) : 0;
                        $isToday = $event->start_date->isToday();
                        $isPast = $event->start_date->isPast() && !$isToday;
                    @endphp
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm hover:border-brand-blue/50 transition">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                     
                            <div class="space-y-1.5 flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h2 class="text-base font-bold text-brand-navy truncate">
                                        {{ $event->title }}
                                    </h2>
                                    @if($isToday)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-circle text-[8px] animate-pulse mr-1"></i> Hari Ini
                                    </span>
                                    @elseif($isPast)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        Selesai
                                    </span>
                                    @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-brand-blue border border-blue-200">
                                        Akan Datang
                                    </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-4 text-xs text-slate-500 flex-wrap">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar text-brand-blue"></i>
                                        {{ $event->start_date->translatedFormat('d M Y, H:i') }} WIB
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-brand-coral"></i>
                                        {{ $event->location }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center gap-4 shrink-0">
                                <div class="text-left sm:text-right">
                                    <div class="text-xs font-bold text-brand-navy">
                                        <span class="text-emerald-600">{{ $checkedIn }}</span> / {{ $confirmed }} Hadir
                                        <span class="text-slate-400 font-normal">({{ $pct }}%)</span>
                                    </div>
                                    <div class="w-full sm:w-36 h-2 rounded-full bg-slate-100 overflow-hidden mt-1.5 border border-slate-200/60">
                                        <div class="h-full bg-brand-blue rounded-full transition-all duration-300" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('organisasi.attendance.show', $event) }}"
                                   class="inline-flex items-center justify-center gap-2 bg-brand-navy hover:bg-[#121E38] text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                                    <i class="fa-solid fa-qrcode text-brand-cyan"></i>
                                    <span>Buka Presensi</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 text-brand-blue border border-blue-200 flex items-center justify-center text-2xl mx-auto mb-3">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 class="text-base font-bold text-brand-navy">Belum Ada Acara</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                            Acara yang Anda selenggarakan akan muncul di sini untuk dikelola kehadiran pesertanya.
                        </p>
                        <a href="{{ route('organisasi.events.create') }}" class="mt-4 inline-flex items-center gap-2 bg-brand-blue hover:bg-[#1a7fe8] text-white rounded-xl px-4 py-2.5 text-xs font-bold transition">
                            <i class="fa-solid fa-plus"></i> Buat Acara Baru
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($events->hasPages())
            <div class="mt-6">
                {{ $events->links() }}
            </div>
            @endif

        </main>
    </div>

    @include('organisasi.partials.footer')

</body>
</html>