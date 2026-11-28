<!DOCTYPE html>
<html lang="id">

<head>
    @include('organisasi.partials.head')
    <title>Acara Saya - Penyelenggara Univents</title>
</head>

<body class="bg-brand-warmBg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('organisasi.partials.header', ['title' => 'Manajemen Acara'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('organisasi.partials.sidebar', ['active' => 'events'])

        <main class="flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Manajemen Acara Saya</h1>
                    <p class="text-xs text-slate-500 mt-1">Kelola dan pantau seluruh kegiatan yang dibuat oleh organisasi Anda.</p>
                </div>
                <a href="{{ route('organisasi.events.create') }}"
                   class="inline-flex items-center gap-2 bg-brand-blue hover:bg-[#1a7fe8] text-white rounded-xl px-4 py-2.5 text-xs font-bold transition shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-plus"></i>
                    <span>Buat Acara Baru</span>
                </a>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-brand-blue"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Acara</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $stats['all'] }}</span>
                    <i class="fa-solid fa-layer-group absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
          
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-amber-400"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Menunggu Admin</span>
                    <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $stats['pending'] }}</span>
                    <i class="fa-solid fa-hourglass-half absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-emerald-500"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Disetujui</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $stats['approved'] }}</span>
                    <i class="fa-solid fa-circle-check absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-brand-coral"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Ditolak</span>
                    <span class="text-2xl font-extrabold text-brand-coral mt-1 block">{{ $stats['rejected'] }}</span>
                    <i class="fa-solid fa-circle-xmark absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
                </div>

            </div>

            <div class="flex items-center gap-2 mb-6 text-xs font-semibold overflow-x-auto pb-1">
                <a href="{{ route('organisasi.dashboard') }}"
                   class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ !request('status') ? 'bg-brand-navy text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-navy' }}">
                    Semua ({{ $stats['all'] }})
                </a>
                <a href="{{ route('organisasi.dashboard', ['status' => 'pending']) }}"
                   class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ request('status') === 'pending' ? 'bg-brand-navy text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-navy' }}">
                    Menunggu ({{ $stats['pending'] }})
                </a>
                <a href="{{ route('organisasi.dashboard', ['status' => 'approved']) }}"
                   class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ request('status') === 'approved' ? 'bg-brand-navy text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-navy' }}">
                    Disetujui ({{ $stats['approved'] }})
                </a>
                <a href="{{ route('organisasi.dashboard', ['status' => 'rejected']) }}"
                   class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ request('status') === 'rejected' ? 'bg-brand-navy text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-navy' }}">
                    Ditolak ({{ $stats['rejected'] }})
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="p-4 text-[11px] uppercase tracking-wider text-slate-400 font-bold">Acara</th>
                                <th class="p-4 text-[11px] uppercase tracking-wider text-slate-400 font-bold">Kategori &amp; Tipe</th>
                                <th class="p-4 text-[11px] uppercase tracking-wider text-slate-400 font-bold">Jadwal &amp; Peserta</th>
                                <th class="p-4 text-[11px] uppercase tracking-wider text-slate-400 font-bold">Status Verifikasi</th>
                                <th class="p-4 text-[11px] uppercase tracking-wider text-slate-400 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($events as $event)
                            <tr class="hover:bg-slate-50/50 transition">

                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        @if($event->banner)
                                        <img src="{{ asset('storage/' . $event->banner) }}"
                                             class="w-12 h-12 rounded-xl object-cover border border-slate-100 shrink-0"
                                             alt="{{ $event->title }}">
                                        @else
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-100 flex items-center justify-center text-slate-300 shrink-0">
                                            <i class="fa-regular fa-image text-lg"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-brand-navy text-sm leading-snug">{{ $event->title }}</h4>
                                            <p class="text-[11px] text-slate-400 mt-0.5">
                                                <i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px] block w-fit mb-1">
                                        {{ $event->category->name ?? '-' }}
                                    </span>
                                    <span class="text-[11px] font-bold {{ $event->isPaid() ? 'text-amber-600' : 'text-emerald-600' }}">
                                        {{ $event->isPaid() ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Gratis' }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <p class="font-semibold text-slate-700 text-xs">
                                        {{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }}
                                    </p>
                                    <a href="{{ route('organisasi.events.participants', $event->id) }}"
                                       class="inline-flex items-center gap-1 text-[11px] font-semibold text-brand-blue hover:underline mt-0.5">
                                        <i class="fa-solid fa-users"></i>
                                        Peserta: {{ $event->participants_count }}/{{ $event->quota }}
                                    </a>
                                </td>

                                <td class="p-4">
                                    @if($event->status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold border bg-emerald-50 text-emerald-600 border-emerald-200">
                                        <i class="fa-solid fa-circle-check"></i> Disetujui
                                    </span>
                                    @elseif($event->status === 'rejected')
                                    <div>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold border bg-rose-50 text-brand-coral border-rose-200">
                                            <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                        </span>
                                        @if($event->rejection_reason)
                                        <p class="text-[10px] text-brand-coral mt-1 italic max-w-xs">"{{ $event->rejection_reason }}"</p>
                                        @endif
                                    </div>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold border bg-amber-50 text-amber-600 border-amber-200">
                                        <i class="fa-solid fa-hourglass-half"></i> Menunggu Admin
                                    </span>
                                    @endif
                                </td>

                                <td class="p-4 text-center">
                                    @if($event->status === 'approved')
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-400 border border-slate-200">
                                            <i class="fa-solid fa-lock text-[10px]"></i>
                                            <span>Terkunci</span>
                                        </span>
                                        <a href="{{ route('events.show', $event->slug) }}" target="_blank"
                                           class="p-1.5 rounded-lg text-slate-400 hover:text-brand-navy hover:bg-slate-100 transition"
                                           title="Lihat di Katalog Publik">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                        </a>
                                        <a href="{{ route('organisasi.events.participants', $event->id) }}"
                                           class="p-1.5 rounded-lg text-emerald-600 hover:bg-emerald-50 transition"
                                           title="Lihat Peserta">
                                            <i class="fa-solid fa-users text-xs"></i>
                                        </a>
                                    </div>
                                    @else
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('organisasi.events.edit', $event->id) }}"
                                           class="p-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-brand-blue transition"
                                           title="Edit Acara">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('organisasi.events.destroy', $event->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-brand-coral transition"
                                                    title="Hapus Acara">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-regular fa-calendar-xmark text-slate-300 text-4xl"></i>
                                        <p class="text-slate-400 font-semibold text-sm">Belum ada acara</p>
                                        <p class="text-slate-400 text-xs">Belum ada acara yang dibuat pada kategori status ini.</p>
                                        <a href="{{ route('organisasi.events.create') }}"
                                           class="mt-2 inline-flex items-center gap-2 bg-brand-blue hover:bg-[#1a7fe8] text-white rounded-xl px-4 py-2.5 text-xs font-bold transition">
                                            <i class="fa-solid fa-plus"></i> Buat Acara Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($events->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $events->links() }}
                </div>
                @endif

            </div>

        </main>
    </div>

    @include('organisasi.partials.footer')

</body>
</html>
