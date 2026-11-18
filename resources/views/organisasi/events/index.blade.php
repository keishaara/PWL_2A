<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acara Saya - Penyelenggara Univents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#162945',
                            coral: '#F45D69',
                            cyan: '#39D9C1',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain">
                <span class="text-xl font-extrabold tracking-tight text-white">Uni<span class="text-brand-cyan">vents</span></span>
                <span class="ml-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-400/20 text-blue-300 border border-blue-400/30 uppercase tracking-wider">Penyelenggara</span>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-white/90">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('organisasi.partials.sidebar', ['active' => 'events'])

        <main class="flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Manajemen Acara Saya</h1>
                    <p class="text-xs text-slate-500 mt-1">Kelola dan pantau seluruh kegiatan yang dibuat oleh organisasi Anda.</p>
                </div>
                <a href="{{ route('organisasi.events.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-coral hover:bg-[#e04d59] text-white text-xs font-bold transition shadow-md shadow-brand-coral/20">
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
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Acara</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $stats['all'] }}</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-amber-200 bg-amber-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block">Menunggu Admin</span>
                    <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $stats['pending'] }}</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-emerald-200 bg-emerald-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Disetujui</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $stats['approved'] }}</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-rose-200 bg-rose-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-rose-600 uppercase tracking-wider block">Ditolak</span>
                    <span class="text-2xl font-extrabold text-rose-600 mt-1 block">{{ $stats['rejected'] }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2 mb-6 text-xs font-semibold overflow-x-auto pb-1">
                <a href="{{ route('organisasi.dashboard') }}" class="px-4 py-2 rounded-xl transition {{ !request('status') ? 'bg-brand-navy text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-navy' }}">
                    Semua ({{ $stats['all'] }})
                </a>
                <a href="{{ route('organisasi.dashboard', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-amber-500' }}">
                    Menunggu ({{ $stats['pending'] }})
                </a>
                <a href="{{ route('organisasi.dashboard', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-600' }}">
                    Disetujui ({{ $stats['approved'] }})
                </a>
                <a href="{{ route('organisasi.dashboard', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-rose-600' }}">
                    Ditolak ({{ $stats['rejected'] }})
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                                <th class="p-4">Acara</th>
                                <th class="p-4">Kategori & Tipe</th>
                                <th class="p-4">Jadwal & Kuota</th>
                                <th class="p-4">Status Verifikasi</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($events as $event)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        @if($event->banner)
                                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 shrink-0">
                                        @else
                                        <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 shrink-0">
                                            <i class="fa-regular fa-image"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-brand-navy text-sm">{{ $event->title }}</h4>
                                            <p class="text-[11px] text-slate-400 mt-0.5"><i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}</p>
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
                                    <p class="font-semibold text-slate-700">{{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Kuota: {{ $event->quota }} peserta</p>
                                </td>
                                <td class="p-4">
                                    @if($event->status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check"></i> Disetujui
                                    </span>
                                    @elseif($event->status === 'rejected')
                                    <div>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                            <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                        </span>
                                        @if($event->rejection_reason)
                                        <p class="text-[10px] text-rose-500 mt-1 italic max-w-xs">"{{ $event->rejection_reason }}"</p>
                                        @endif
                                    </div>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
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
                                        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-navy hover:bg-slate-100 transition" title="Lihat di Katalog Publik">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                        </a>
                                    </div>
                                    @else
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('organisasi.events.edit', $event->id) }}" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-brand-navy transition" title="Edit Acara">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('organisasi.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition" title="Hapus Acara">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400">
                                    <i class="fa-regular fa-calendar-xmark text-3xl mb-2 block"></i>
                                    Belum ada acara yang dibuat pada kategori status ini.
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