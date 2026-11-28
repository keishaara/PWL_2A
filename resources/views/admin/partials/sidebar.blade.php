@php
    $items = [
        'verification' => ['Verifikasi Acara', route('admin.dashboard'), 'fa-clipboard-check'],
        'transactions' => ['Monitoring Transaksi', route('admin.transactions.index'), 'fa-chart-line'],
        'categories' => ['Kelola Kategori', route('admin.categories.index'), 'fa-tags'],
        'profile' => ['Profil Admin', route('admin.profile'), 'fa-user'],
    ];
@endphp

{{-- Overlay gelap di belakang drawer (khusus mobile) --}}
<div id="adminSidebarOverlay" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[45] hidden md:hidden"></div>

<aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85%] -translate-x-full transition-transform duration-200 ease-out bg-slate-50 p-4 overflow-y-auto shadow-2xl shrink-0
                               md:sticky md:top-24 md:self-start md:z-auto md:w-64 md:max-w-none md:translate-x-0 md:bg-transparent md:p-0 md:max-h-[calc(100vh-7rem)] md:overflow-y-auto md:shadow-none">
    {{-- Header drawer, hanya tampil di mobile --}}
    <div class="flex items-center justify-between mb-4 md:hidden">
        <span class="text-sm font-extrabold text-brand-navy">Menu</span>
        <button type="button" onclick="toggleAdminSidebar()" aria-label="Tutup menu" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Menu Administrator</div>

            @foreach ($items as $key => [$label, $url, $icon])
                @php $isActive = ($active ?? 'verification') === $key; @endphp
                <a href="{{ $url }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $isActive ? 'font-bold bg-brand-navy text-white shadow-sm' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy' }}">
                    <i class="fa-solid {{ $icon }} w-4 text-center {{ $isActive ? 'text-amber-400' : '' }}"></i>
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
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');
        const willOpen = sidebar.classList.contains('-translate-x-full');

        sidebar.classList.toggle('-translate-x-full', !willOpen);
        overlay.classList.toggle('hidden', !willOpen);
        document.body.classList.toggle('overflow-hidden', willOpen);
    }

    document.addEventListener('keydown', function (e) {
        const sidebar = document.getElementById('adminSidebar');
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            toggleAdminSidebar();
        }
    });
</script>