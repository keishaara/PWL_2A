<footer class="bg-brand-navy text-white mt-12 border-t border-white/10 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="space-y-3">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight">Uni<span class="text-brand-cyan">vents</span></span>
                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400/20 text-amber-300 border border-amber-400/30 uppercase tracking-wider">Admin</span>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed max-w-xs">
                    Pusat kendali operasional Univents. Memoderasi seluruh pengajuan acara kampus, tata kelola kategori, serta pengawasan transaksi.
                </p>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-brand-cyan mb-3">Panel Kontrol</h4>
                <ul class="grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-slate-300">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-brand-cyan transition">Verifikasi Pengajuan Acara</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="hover:text-brand-cyan transition">Manajemen Kategori</a></li>
                    <li><a href="{{ route('admin.transactions.index') }}" class="hover:text-brand-cyan transition">Monitoring Transaksi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-brand-cyan mb-3">Pedoman Verifikasi</h4>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-triangle-exclamation w-4 text-amber-400 mt-0.5 shrink-0"></i>
                        <span>Pastikan informasi acara tidak melanggar tata tertib dan etika kampus sebelum disetujui.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-file-excel w-4 text-emerald-400 mt-0.5 shrink-0"></i>
                        <span>Gunakan fitur ekspor berkala untuk pelaporan dan arsip keuangan kampus.</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="mt-8 pt-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
            <span>&copy; {{ date('Y') }} Univents Kampus. Hak cipta dilindungi.</span>
            <span>Sistem Administrasi Pusat Univents</span>
        </div>
    </div>
</footer>