@php
    $items = [
        'events'        => ['Acara Saya', route('organisasi.dashboard'), 'fa-calendar-days'],
        'create_event'  => ['Buat Acara Baru', route('organisasi.events.create'), 'fa-plus-circle'],
        // Menu untuk teman-teman tim (Zahra, Dinda, Fahmi):
        // 'participants'  => ['Daftar Peserta', '#', 'fa-users'],
        // 'payments'      => ['Verifikasi Pembayaran', '#', 'fa-receipt'],
        // 'attendance'    => ['Presensi Hari-H', '#', 'fa-qrcode'],
    ];
@endphp

<aside class="w-full md:w-64 shrink-0 space-y-4">
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Navigasi Penyelenggara</div>

        @foreach ($items as $key => [$label, $url, $icon])
            @php $isActive = ($active ?? 'events') === $key; @endphp
            <a href="{{ $url }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $isActive ? 'font-bold bg-brand-navy text-white shadow-sm' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy' }}">
                <i class="fa-solid {{ $icon }} w-4 text-center {{ $isActive ? 'text-brand-cyan' : '' }}"></i>
                <span>{{ $label }}</span>
            </a>
        @endforeach

        <form action="{{ route('logout') }}" method="POST" class="pt-2">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-brand-coral hover:bg-rose-50 transition text-left">
                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                <span>Keluar Akun</span>
            </button>
        </form>
    </div>
</aside>