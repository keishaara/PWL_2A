<!DOCTYPE html>
<html lang="id">
<head>
    @include('mahasiswa.partials.head')
    <title>Presensi Acara - Univents</title>
</head>
<body class="min-h-screen text-brand-navy">
    <header class="bg-brand-navy text-white p-4 font-bold">Presensi Hari-H</header>
    <div class="max-w-7xl mx-auto p-4 md:p-8 flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'attendance'])
        <main class="flex-1">
            <h1 class="text-2xl font-extrabold mb-2">Presensi Acara</h1>
            <p class="text-sm text-slate-500 mb-6">Pilih acara untuk melihat peserta dan memvalidasi tiket masuk.</p>
            @if (session('success'))<p class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm">{{ session('success') }}</p>@endif
            <div class="space-y-3">
                @forelse ($events as $event)
                    <a href="{{ route('organisasi.attendance.show', $event) }}" class="block p-5 bg-white border border-slate-200 rounded-xl hover:border-brand-cyan">
                        <div class="flex flex-wrap justify-between gap-3">
                            <div><h2 class="font-bold">{{ $event->title }}</h2><p class="text-xs text-slate-500 mt-1">{{ $event->start_date->format('d M Y H:i') }} · {{ $event->location }}</p></div>
                            <span class="text-sm font-semibold">{{ $event->checked_in_count }}/{{ $event->confirmed_registrations_count }} peserta hadir</span>
                        </div>
                    </a>
                @empty
                    <p class="p-6 text-center bg-white rounded-xl text-slate-500">Belum ada acara.</p>
                @endforelse
            </div>
            <div class="mt-5">{{ $events->links() }}</div>
        </main>
    </div>
</body>
</html>
