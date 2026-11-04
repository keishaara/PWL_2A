<footer class="bg-brand-navy text-white mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="space-y-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight">Uni<span class="text-brand-cyan">vents</span></span>
                </a>
                <p class="text-xs text-slate-300 leading-relaxed max-w-xs">
                    Platform terintegrasi untuk menemukan, mendaftar, dan mengelola kegiatan kampus bagi mahasiswa dan organisasi mahasiswa.
                </p>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-brand-cyan mb-3">Menu Mahasiswa</h4>
                <ul class="grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-slate-300">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-brand-cyan transition">Dashboard</a></li>
                    <li><a href="{{ route('events.index') }}" class="hover:text-brand-cyan transition">Katalog Acara</a></li>
                    <li><a href="{{ route('tickets.index') }}" class="hover:text-brand-cyan transition">E-Tiket Saya</a></li>
                    <li><a href="{{ route('bookmarks.index') }}" class="hover:text-brand-cyan transition">Event Tersimpan</a></li>
                    <li><a href="{{ route('payments.index') }}" class="hover:text-brand-cyan transition">Status Pembayaran</a></li>
                    <li><a href="{{ route('profile.show') }}" class="hover:text-brand-cyan transition">Profil Mahasiswa</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-brand-cyan mb-3">Tentang Platform</h4>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-ticket w-4 text-brand-coral"></i>Pendaftaran acara &amp; e-tiket digital</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-bookmark w-4 text-brand-amber"></i>Simpan acara favoritmu</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check w-4 text-brand-cyan"></i>Tiket terverifikasi dengan QR Code</li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
            <span>&copy; {{ date('Y') }} Univents Kampus. Hak cipta dilindungi.</span>
            <span>Platform Terintegrasi Mahasiswa &amp; Ormawa</span>
        </div>
    </div>
</footer>