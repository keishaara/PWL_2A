<!DOCTYPE html>
<html lang="id">
<head>
    @include('organisasi.partials.head')
    <title>Meja Presensi: {{ $event->title }} - Univents</title>
</head>
<body class="bg-brand-warmBg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('organisasi.partials.header', ['title' => 'Presensi Hari-H'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'attendance'])

        <main class="flex-1 min-w-0">

            <div class="mb-4">
                <a href="{{ route('organisasi.attendance.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-brand-navy transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Daftar Presensi</span>
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-brand-blue border border-blue-200">
                                {{ $event->category->name ?? 'Acara' }}
                            </span>
                            @if($event->start_date->isToday())
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-circle text-[8px] animate-pulse mr-1"></i> Hari-H Berlangsung
                            </span>
                            @endif
                        </div>
                        <h1 class="text-2xl font-extrabold text-brand-navy">{{ $event->title }}</h1>
                        <div class="flex items-center gap-4 text-xs text-slate-500 mt-2 flex-wrap">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar text-brand-blue"></i>
                                {{ $event->start_date->translatedFormat('l, d F Y - H:i') }} WIB
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-brand-coral"></i>
                                {{ $event->location }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('events.show', $event->slug) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition shrink-0">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                        <span>Katalog Publik</span>
                    </a>
                </div>
            </div>

            @php
                $confirmedCount = $event->registrations()->where('status', 'confirmed')->count();
                $checkedInCount = $event->registrations()->where('status', 'confirmed')->whereHas('ticket', fn($t) => $t->where('status', 'used'))->count();
                $remainingCount = max(0, $confirmedCount - $checkedInCount);
                $percentage = $confirmedCount > 0 ? round(($checkedInCount / $confirmedCount) * 100) : 0;
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-brand-blue"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Kuota Terisi</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $confirmedCount }}</span>
                    <i class="fa-solid fa-users absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-emerald-500"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Sudah Hadir</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $checkedInCount }}</span>
                    <i class="fa-solid fa-circle-check absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-amber-400"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Belum Hadir</span>
                    <span class="text-2xl font-extrabold text-amber-500 mt-1 block">{{ $remainingCount }}</span>
                    <i class="fa-solid fa-hourglass-half absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-brand-cyan"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tingkat Kehadiran</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $percentage }}%</span>
                    <i class="fa-solid fa-chart-pie absolute right-4 bottom-3 text-slate-100 text-2xl"></i>
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

            @if (isset($errors) && $errors->has('ticket_code'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-brand-coral text-base"></i>
                    <span>{{ $errors->first('ticket_code') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            <div class="bg-gradient-to-r from-brand-navy to-[#1f3a63] rounded-2xl p-6 sm:p-7 text-white shadow-md mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-qrcode text-brand-cyan text-xl"></i>
                        <h2 class="text-base font-bold">Validasi Check-In Tiket Masuk</h2>
                    </div>
                    <span class="text-[11px] text-slate-300">Scan QR Code tiket atau masukkan kode tiket peserta</span>
                </div>

                <form action="{{ route('organisasi.attendance.check-in', $event) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="relative flex-1">
                        <i class="fa-solid fa-barcode absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input
                            type="text"
                            id="ticket_code"
                            name="ticket_code"
                            value="{{ old('ticket_code') }}"
                            required
                            autofocus
                            placeholder="Contoh: TIK-ABC123XYZ"
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-white text-brand-navy text-sm font-mono font-bold tracking-wider uppercase placeholder:font-sans placeholder:font-normal placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-cyan shadow-inner">
                    </div>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-brand-blue hover:bg-[#1a7fe8] text-white text-xs font-bold px-6 py-3 rounded-xl transition shadow-md shadow-blue-500/20 shrink-0">
                        <i class="fa-solid fa-check-double"></i>
                        <span>Validasi Masuk</span>
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-extrabold text-sm text-brand-navy">Daftar Kehadiran Peserta</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Memuat data tiket peserta yang telah terkonfirmasi.</p>
                    </div>

                    <div class="relative w-full sm:w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input
                            type="text"
                            id="searchParticipants"
                            onkeyup="filterAttendanceTable()"
                            placeholder="Cari nama, email, tiket..."
                            class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs" id="attendanceTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                                <th class="p-4">Peserta</th>
                                <th class="p-4">Kode Tiket</th>
                                <th class="p-4">Status Presensi</th>
                                <th class="p-4 text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($registrations as $registration)
                                @php
                                    $isUsed = $registration->ticket?->status === 'used';
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition participant-row">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 text-brand-navy font-bold text-xs flex items-center justify-center shrink-0 border border-slate-200">
                                                {{ strtoupper(substr($registration->user->name ?? 'P', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-brand-navy participant-name">{{ $registration->user->name }}</div>
                                                <div class="text-[11px] text-slate-400 participant-email">{{ $registration->user->email }}</div>
                                                @if(!empty($registration->user->npm))
                                                <div class="text-[10px] text-slate-400 font-mono">NPM: {{ $registration->user->npm }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4 font-mono font-bold text-slate-700 participant-ticket">
                                        @if($registration->ticket)
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs">
                                            {{ $registration->ticket->ticket_code }}
                                        </span>
                                        @else
                                        <span class="text-slate-400 italic text-[11px]">Belum terbit</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if ($isUsed)
                                        <div>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i> Hadir
                                            </span>
                                            @if ($registration->ticket?->checked_in_at)
                                            <span class="block text-[10px] text-slate-400 mt-1">
                                                {{ $registration->ticket->checked_in_at->translatedFormat('d M, H:i') }} WIB
                                            </span>
                                            @endif
                                        </div>
                                        @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <i class="fa-regular fa-clock text-[10px]"></i> Belum Hadir
                                        </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @if ($registration->ticket && !$isUsed)
                                            <form action="{{ route('organisasi.attendance.check-in', $event) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="ticket_code" value="{{ $registration->ticket->ticket_code }}">
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>Tandai Hadir</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-slate-400 text-xs font-semibold">
                                                <i class="fa-solid fa-check-double text-emerald-500"></i> Terverifikasi
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-slate-400">
                                        <i class="fa-solid fa-users-slash text-3xl mb-2 text-slate-300 block"></i>
                                        Belum ada peserta yang terkonfirmasi pada acara ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($registrations->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $registrations->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>

    @include('organisasi.partials.footer')

    <script>
        function filterAttendanceTable() {
            const input = document.getElementById('searchParticipants').value.toLowerCase();
            const rows = document.querySelectorAll('.participant-row');
            rows.forEach(row => {
                const name = row.querySelector('.participant-name')?.textContent.toLowerCase() || '';
                const email = row.querySelector('.participant-email')?.textContent.toLowerCase() || '';
                const ticket = row.querySelector('.participant-ticket')?.textContent.toLowerCase() || '';
                if (name.includes(input) || email.includes(input) || ticket.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

</body>
</html>