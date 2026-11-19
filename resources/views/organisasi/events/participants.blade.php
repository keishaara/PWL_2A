<!DOCTYPE html>
<html lang="id">

<head>
    @include('mahasiswa.partials.head')
    <title>Daftar Peserta - Univents</title>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    @include('organisasi.partials.header', ['title' => 'Daftar Peserta'])
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'events'])
        <main class="flex-1 min-w-0">
            <a href="{{ route('organisasi.dashboard') }}" class="text-sm text-slate-500 hover:underline">← Acara
                Saya</a>
            <h1 class="text-2xl font-extrabold mt-3">{{ $event->title }}</h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ $event->start_date->format('d M Y H:i') }} · {{ $event->location }} · Peserta: {{ $stats['confirmed'] }}/{{ $event->quota }}
            </p>

            <form method="GET"
                class="my-6 p-2 bg-white border border-slate-200 rounded-xl flex flex-col sm:flex-row gap-3">
                <input name="q" value="{{ request('q') }}" placeholder="Cari nama atau NPM" class="flex-1 rounded-lg border-slate-300 text-sm px-3 py-0">
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <button class="px-5 py-2 rounded-lg bg-brand-navy text-white text-sm font-bold">Cari</button>
            </form>

            <div class="flex items-center gap-2 my-6 text-xs font-semibold overflow-x-auto pb-1">
                <a href="{{ route('organisasi.events.participants', [$event->id, 'q' => request('q')]) }}"
                    class="px-4 py-2 rounded-xl transition {{ !request('status') ? 'bg-brand-navy text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-navy' }}">
                    Semua ({{ $stats['all'] }})
                </a>
                <a href="{{ route('organisasi.events.participants', [$event->id, 'status' => 'pending', 'q' => request('q')]) }}"
                    class="px-4 py-2 rounded-xl transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-amber-500' }}">
                    Menunggu ({{ $stats['pending'] }})
                </a>
                <a href="{{ route('organisasi.events.participants', [$event->id, 'status' => 'confirmed', 'q' => request('q')]) }}"
                    class="px-4 py-2 rounded-xl transition {{ request('status') === 'confirmed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-600' }}">
                    Terkonfirmasi ({{ $stats['confirmed'] }})
                </a>
                <a href="{{ route('organisasi.events.participants', [$event->id, 'status' => 'cancelled', 'q' => request('q')]) }}"
                    class="px-4 py-2 rounded-xl transition {{ request('status') === 'cancelled' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-rose-600' }}">
                    Dibatalkan ({{ $stats['cancelled'] }})
                </a>
            </div>

            <div class="overflow-x-auto bg-white border border-slate-200 rounded-xl">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">NPM</th>
                            <th class="p-3">Jurusan</th>
                            <th class="p-3">Semester</th>
                            <th class="p-3">Kontak</th>
                            <th class="p-3">Tanggal Daftar</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($registrations as $i => $r)
                            <tr>
                                <td class="p-3">{{ $registrations->firstItem() + $i }}</td>
                                <td class="p-3 font-semibold">{{ $r->user->name }}</td>
                                <td class="p-3">{{ $r->user->npm ?? '-' }}</td>
                                <td class="p-3">{{ $r->user->major ?? '-' }}</td>
                                <td class="p-3">{{ $r->user->semester ?? '-' }}</td>
                                <td class="p-3">{{ $r->user->email }}<br><span
                                        class="text-xs text-slate-500">{{ $r->user->phone }}</span>
                                </td>
                                <td class="p-3">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-3">
                                    {{ ['confirmed' => 'Terkonfirmasi', 'pending' => 'Menunggu', 'cancelled' => 'Dibatalkan'][$r->status] ?? $r->status }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-500">{{ request('q') || request('status') ? 'Tidak ada peserta yang cocok dengan filter.' : 'Belum ada peserta.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-5">{{ $registrations->links() }}</div>
        </main>
    </div>
    @include('organisasi.partials.footer')
</body>

</html>