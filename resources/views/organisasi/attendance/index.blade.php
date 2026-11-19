<!DOCTYPE html>
<html lang="id">
<head>
    @include('mahasiswa.partials.head')
    <title>Presensi Acara - Univents</title>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    @include('organisasi.partials.header', ['title' => 'Presensi Hari-H'])
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'attendance'])
        <main class="flex-1 min-w-0">
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
    @include('organisasi.partials.footer')
</body>
</html>
