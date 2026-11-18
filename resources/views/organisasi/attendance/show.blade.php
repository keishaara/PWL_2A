<!DOCTYPE html>
<html lang="id">
<head>
    @include('mahasiswa.partials.head')
    <title>Daftar Presensi - Univents</title>
</head>
<body class="min-h-screen text-brand-navy">
    <header class="bg-brand-navy text-white p-4 font-bold">Presensi Hari-H</header>
    <div class="max-w-7xl mx-auto p-4 md:p-8 flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'attendance'])
        <main class="flex-1">
            <a href="{{ route('organisasi.attendance.index') }}" class="text-sm text-slate-500 hover:underline">← Semua Acara</a>
            <h1 class="text-2xl font-extrabold mt-3">{{ $event->title }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $event->start_date->format('d M Y H:i') }} · {{ $event->location }}</p>
            @if (session('success'))<p class="my-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm">{{ session('success') }}</p>@endif
            <form action="{{ route('organisasi.attendance.check-in', $event) }}" method="POST" class="my-6 p-4 bg-white border border-slate-200 rounded-xl flex flex-col sm:flex-row gap-3">
                @csrf
                <label for="ticket_code" class="sr-only">Kode tiket peserta</label>
                <input id="ticket_code" name="ticket_code" value="{{ old('ticket_code') }}" required autofocus placeholder="Masukkan atau scan kode tiket" class="flex-1 rounded-lg border-slate-300 text-sm">
                <button class="px-5 py-2 rounded-lg bg-brand-navy text-white text-sm font-bold">Validasi Check-In</button>
            </form>
            @error('ticket_code')<p class="mb-4 text-sm text-rose-600">{{ $message }}</p>@enderror
            <div class="overflow-x-auto bg-white border border-slate-200 rounded-xl">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="p-3">Peserta</th><th class="p-3">Kode Tiket</th><th class="p-3">Presensi</th><th class="p-3">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($registrations as $registration)
                            <tr>
                                <td class="p-3"><span class="font-semibold">{{ $registration->user->name }}</span><br><span class="text-xs text-slate-500">{{ $registration->user->email }}</span></td>
                                <td class="p-3 font-mono">{{ $registration->ticket?->ticket_code ?? 'Belum ada tiket' }}</td>
                                <td class="p-3">{{ $registration->ticket?->status === 'used' ? 'Hadir' : 'Belum hadir' }}
                                    @if ($registration->ticket?->checked_in_at)<span class="block text-xs text-slate-500">{{ $registration->ticket->checked_in_at->format('d/m/Y H:i') }}</span>@endif
                                </td>
                                <td class="p-3">
                                    @if ($registration->ticket && $registration->ticket->status !== 'used')
                                        <form action="{{ route('organisasi.attendance.check-in', $event) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="ticket_code" value="{{ $registration->ticket->ticket_code }}">
                                            <button class="text-xs font-bold text-emerald-700 hover:underline">Tandai Hadir</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-emerald-700">Terverifikasi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-8 text-center text-slate-500">Belum ada peserta terkonfirmasi.</td></tr>
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
