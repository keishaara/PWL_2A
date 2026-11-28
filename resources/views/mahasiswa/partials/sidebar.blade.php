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

{{-- Overlay gelap di belakang drawer (khusus mobile) --}}
<div id="studentSidebarOverlay" onclick="toggleStudentSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[45] hidden md:hidden"></div>

<aside id="studentSidebar" class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85%] -translate-x-full transition-transform duration-200 ease-out bg-slate-50 p-4 overflow-y-auto shadow-2xl shrink-0
                                 md:sticky md:top-24 md:self-start md:z-auto md:w-64 md:max-w-none md:translate-x-0 md:bg-transparent md:p-0 md:max-h-[calc(100vh-7rem)] md:overflow-y-auto md:shadow-none">

    {{-- Header drawer (khusus mobile) --}}
    <div class="flex items-center justify-between mb-4 md:hidden">
        <span class="text-sm font-extrabold text-brand-navy">Menu</span>
        <button type="button" onclick="toggleStudentSidebar()" aria-label="Tutup menu" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Navigasi Akun</div>

            @foreach ($items as $key => [$label, $url, $icon])
                @php $isActive = ($active ?? '') === $key; @endphp
                <a href="{{ $url }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $isActive ? 'font-bold bg-brand-navy text-white shadow-sm' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy' }}">
                    <i class="fa-solid {{ $icon }} w-4 text-center {{ $isActive ? 'text-brand-blue' : '' }}"></i>
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

        <!-- <div class="bg-brand-navy text-white p-3 rounded-2xl border border-slate-800 shadow-sm text-center">
            <p class="text-[11px] text-slate-300 leading-relaxed">
                Cari acara seru dan kumpulkan sertifikat digital!
            </p>
        </div> -->
    </div>
</aside>

<script>
    function toggleStudentSidebar() {
        const sidebar = document.getElementById('studentSidebar');
        const overlay = document.getElementById('studentSidebarOverlay');
        const isDesktop = window.innerWidth >= 768;

        if (isDesktop) {
            // DI LAPTOP / DESKTOP: Sembunyikan sidebar agar konten utama otomatis melebar!
            sidebar.classList.toggle('md:hidden');

            // Simpan status ke memori browser agar pas pindah halaman tetap konsisten
            const isHidden = sidebar.classList.contains('md:hidden');
            localStorage.setItem('univents_sidebar_collapsed', isHidden ? '1' : '0');
        } else {
            // DI HP / MOBILE: Buka / tutup drawer dari samping
            const willOpen = sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', !willOpen);
            overlay.classList.toggle('hidden', !willOpen);
            document.body.classList.toggle('overflow-hidden', willOpen);
        }
    }

    // Pas halaman dibuka di laptop, cek apakah user sebelumnya memilih sembunyikan sidebar
    document.addEventListener('DOMContentLoaded', function () {
        if (window.innerWidth >= 768 && localStorage.getItem('univents_sidebar_collapsed') === '1') {
            document.getElementById('studentSidebar')?.classList.add('md:hidden');
        }
    });

    // Menutup drawer saat tekan tombol ESC di keyboard
    document.addEventListener('keydown', function (e) {
        const sidebar = document.getElementById('studentSidebar');
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 768) {
            toggleStudentSidebar();
        }
    });
</script>