@php
    $items = [
        'verification' => ['Verifikasi Acara', route('admin.dashboard'), 'fa-clipboard-check'],
        // Nanti Zahra & Dinda tinggal aktifkan route di bawah ini:
        // 'categories' => ['Kelola Kategori', '#', 'fa-tags'],
        // 'transactions' => ['Monitoring Transaksi', '#', 'fa-chart-line'],
    ];
@endphp

<aside class="w-full md:w-64 shrink-0 space-y-4">
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Menu Administrator</div>

        @foreach ($items as $key => [$label, $url, $icon])
            @php $isActive = ($active ?? 'verification') === $key; @endphp
            <a href="{{ $url }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $isActive ? 'font-bold bg-brand-navy text-white shadow-sm' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy' }}">
                <i class="fa-solid {{ $icon }} w-4 text-center {{ $isActive ? 'text-amber-400' : '' }}"></i>
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
        <div class="w-10 h-10 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 flex items-center justify-center mx-auto mb-2 text-base font-bold">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h4 class="text-xs font-bold text-amber-300 uppercase tracking-wider mb-1">Super Admin</h4>
        <p class="text-[11px] text-slate-300 leading-relaxed">
            Anda memiliki wewenang penuh untuk memverifikasi acara kampus dan mengelola konten platform.
        </p>
    </div>
</aside>