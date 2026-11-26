@php
    $items = [
        'events'        => ['Acara Saya', route('organisasi.dashboard'), 'fa-calendar-days'],
        'create_event'  => ['Buat Acara Baru', route('organisasi.events.create'), 'fa-plus-circle'],
        'payments'      => ['Verifikasi Pembayaran', route('organisasi.payments.index'), 'fa-receipt'],
        'attendance'    => ['Presensi Hari-H', route('organisasi.attendance.index'), 'fa-user-check'],
        'reviews'       => ['Rekap Ulasan', route('organisasi.reviews.index'), 'fa-star'],
    ];
@endphp

<div id="organisasiSidebarOverlay" onclick="toggleOrganisasiSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[45] hidden md:hidden"></div>

<aside id="organisasiSidebar" class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85%] -translate-x-full transition-transform duration-200 ease-out bg-slate-50 p-4 overflow-y-auto shadow-2xl shrink-0
                                md:sticky md:top-24 md:self-start md:z-auto md:w-64 md:max-w-none md:translate-x-0 md:bg-transparent md:p-0 md:max-h-[calc(100vh-7rem)] md:overflow-y-auto md:shadow-none">
    <div class="flex items-center justify-between mb-4 md:hidden">
        <span class="text-sm font-extrabold text-brand-navy">Menu Penyelenggara</span>
        <button type="button" onclick="toggleOrganisasiSidebar()" aria-label="Tutup menu" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Navigasi Penyelenggara</div>

            @foreach ($items as $key => [$label, $url, $icon])
                @php $isActive = ($active ?? 'events') === $key; @endphp
                <a href="{{ $url }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $isActive ? 'font-bold bg-brand-navy text-white shadow-sm' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy' }}">
                    <i class="fa-solid {{ $icon }} w-4 text-center {{ $isActive ? 'text-brand-cyan' : '' }}"></i>
                    <span>{{ $label }}</span>
                </a>
            @endforeach

            <form action="{{ route('logout') }}" method="POST" class="pt-2" data-confirm-logout>
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-brand-coral hover:bg-rose-50 transition text-left">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    function toggleOrganisasiSidebar() {
        const sidebar = document.getElementById('organisasiSidebar');
        const overlay = document.getElementById('organisasiSidebarOverlay');
        if (!sidebar || !overlay) return;
        const willOpen = sidebar.classList.contains('-translate-x-full');

        if (willOpen) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('organisasiSidebar');
            if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                toggleOrganisasiSidebar();
            }
        }
    });
</script>
