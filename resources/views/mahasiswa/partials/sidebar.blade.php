@php
    $items = [
        'dashboard' => ['Dashboard',         route('dashboard'),       'fa-house'],
        'events'    => ['Katalog Acara',     route('events.index'),    'fa-compass'],
        'tickets'   => ['E-Tiket Saya',      route('tickets.index'),   'fa-ticket'],
        'bookmarks' => ['Event Tersimpan',   route('bookmarks.index'), 'fa-bookmark'],
        'payments'  => ['Status Pembayaran', route('payments.index'),  'fa-receipt'],
        'profile'   => ['Profil Mahasiswa',  route('profile.show'),    'fa-user'],
    ];
@endphp
<aside class="w-full md:w-64 shrink-0 space-y-4">
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Navigasi Akun</div>

        @foreach ($items as $key => [$label, $url, $icon])
            @php $isActive = ($active ?? '') === $key; @endphp
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

    <div class="bg-brand-navy text-white p-5 rounded-2xl border border-slate-800 shadow-sm text-center">
        <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-9 mx-auto object-contain bg-white rounded-lg p-1.5 mb-3">
        <h4 class="text-xs font-bold text-brand-cyan uppercase tracking-wider mb-1">Status Mahasiswa</h4>
        <p class="text-[11px] text-slate-300 leading-relaxed">
            Akun kamu terverifikasi sebagai mahasiswa aktif. Cari acara seru dan kumpulkan sertifikat digital!
        </p>
    </div>
</aside>