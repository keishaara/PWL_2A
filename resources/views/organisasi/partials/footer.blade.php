<footer class="bg-brand-navy text-white mt-12 border-t border-white/10 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="space-y-3">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight">Uni<span class="text-brand-cyan">vents</span></span>
                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-400/20 text-blue-300 border border-blue-400/30 uppercase tracking-wider">Ormawa</span>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed max-w-xs">
                    Ruang kerja digital penyelenggara kegiatan kampus. Publikasikan kegiatan, pantau pendaftar, dan kelola presensi peserta secara transparan.
                </p>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-brand-cyan mb-3">Menu Penyelenggara</h4>
                <ul class="grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-slate-300">
                    <li><a href="{{ route('organisasi.dashboard') }}" class="hover:text-brand-cyan transition">Acara Saya</a></li>
                    <li><a href="{{ route('organisasi.events.create') }}" class="hover:text-brand-cyan transition">Buat Acara Baru</a></li>
                    <li><a href="{{ route('organisasi.payments.index') }}" class="hover:text-brand-cyan transition">Verifikasi Pembayaran</a></li>
                    <li><a href="{{ route('organisasi.attendance.index') }}" class="hover:text-brand-cyan transition">Presensi Hari-H</a></li>
                    <li><a href="{{ route('organisasi.reviews.index') }}" class="hover:text-brand-cyan transition">Rekap Ulasan Peserta</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-brand-cyan mb-3">Panduan Penyelenggara</h4>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-info w-4 text-brand-cyan mt-0.5 shrink-0"></i>
                        <span>Acara yang dibuat memerlukan persetujuan Admin sebelum tampil di katalog mahasiswa.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-shield-halved w-4 text-brand-coral mt-0.5 shrink-0"></i>
                        <span>Pastikan data nomor rekening dan nominal HTM valid agar pendaftar tidak terkendala.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-qrcode w-4 text-emerald-400 mt-0.5 shrink-0"></i>
                        <span>Gunakan kode tiket unik peserta untuk mencatat kehadiran saat hari kegiatan.</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="mt-8 pt-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
            <span>&copy; {{ date('Y') }} Univents Kampus. Hak cipta dilindungi.</span>
            <span>Panel Khusus Organisasi Kemahasiswaan</span>
        </div>
    </div>
</footer>