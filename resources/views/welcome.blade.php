<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Univents - Official Campus Event Space</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkEclipse: '#162945',
                        ripeMalinka: '#F45D69',
                        aquamarine: '#39D9C1',
                        nakedNoodle: '#FCCC6B',
                        surface: '#F8FAFC'
                    },
                    fontFamily: {
                        glacial: ['"Glacial Indifference"', 'sans-serif'],
                        dmsans: ['"DM Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/glacial-indifference-2">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #F8FAFC;
        }
        h1, h2, h3, .font-heading {
            font-family: 'Glacial Indifference', 'DM Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-surface text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-aquamarine selection:text-darkEclipse">

    <header class="w-full bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-9 w-auto object-contain">
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#peran" class="hover:text-darkEclipse transition">Untuk Siapa</a>
                <a href="#fitur" class="hover:text-darkEclipse transition">Fitur Platform</a>
                <a href="#agenda" class="hover:text-darkEclipse transition">Agenda Acara</a>
                <a href="#tentang" class="hover:text-darkEclipse transition">Tentang Kami</a>
            </nav>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        @if(Auth::user()->role === 'student')
                            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-darkEclipse bg-slate-100 hover:bg-slate-200 transition">
                                <i class="fa-regular fa-user text-ripeMalinka"></i>
                                <span>Profil Mahasiswa</span>
                            </a>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-darkEclipse text-white hover:bg-slate-800 transition shadow-sm">
                                <i class="fa-solid fa-house text-aquamarine text-xs"></i>
                                <span>Dashboard</span>
                            </a>
                        @elseif(Auth::user()->role === 'organizer')
                            <a href="{{ route('organisasi.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-darkEclipse text-white hover:bg-slate-800 transition shadow-sm">
                                <span>Dashboard Ormawa</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-darkEclipse text-white hover:bg-slate-800 transition shadow-sm">
                                <span>Dashboard Admin</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-darkEclipse transition">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-darkEclipse text-white hover:bg-slate-800 transition shadow-sm">
                                Daftar Akun
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="flex-grow">

        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">

                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-semibold text-darkEclipse shadow-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-ripeMalinka animate-pulse"></span>
                        <span>Official Campus Event Space</span>
                    </div>

                    <h1 class="font-heading text-4xl sm:text-5xl lg:text-[50px] font-bold text-darkEclipse tracking-tight leading-[1.18]">
                        Pusat Kolaborasi & Kegiatan Kampus Terintegrasi.
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Univents menghubungkan mahasiswa aktif dan organisasi kemahasiswaan. Memfasilitasi publikasi kegiatan, pendaftaran praktis, klaim tiket digital, hingga pencatatan keaktifan acara dalam satu ekosistem terpadu.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#peran" class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-sm font-bold bg-darkEclipse text-white hover:bg-slate-800 transition shadow-sm flex items-center justify-center gap-2">
                            <span>Pelajari Alur Layanan</span>
                            <i class="fa-solid fa-arrow-down text-xs text-aquamarine"></i>
                        </a>
                        <a href="#agenda" class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-sm font-semibold bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 transition flex items-center justify-center gap-2 shadow-sm">
                            <span>Jelajahi Agenda Kampus</span>
                            <i class="fa-regular fa-calendar-check text-xs text-ripeMalinka"></i>
                        </a>
                    </div>


                </div>

                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-sm sm:max-w-md">
                        <div class="absolute -top-3 -right-3 w-full h-full rounded-3xl bg-aquamarine/20 border border-aquamarine/40 -z-10"></div>
                        
                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-xl space-y-5">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-aquamarine"></span>
                                    <span class="font-heading font-bold text-xs uppercase tracking-wider text-darkEclipse">Ekosistem Univents</span>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    Aktif Semester Ini
                                </span>
                            </div>

                            <div class="space-y-3">
                                <a href="#agenda" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-3.5 hover:border-aquamarine transition block">
                                    <div class="w-10 h-10 rounded-xl bg-darkEclipse text-aquamarine flex items-center justify-center font-bold text-base shrink-0">
                                        <i class="fa-solid fa-code"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-heading text-xs font-bold text-darkEclipse truncate">Web Tech & Framework 2026</h4>
                                        <p class="text-[11px] text-slate-500">Workshop • Himpunan Mahasiswa</p>
                                    </div>
                                    <span class="text-[10px] font-bold text-darkEclipse px-2 py-0.5 bg-white border border-slate-200 rounded-md shrink-0">
                                        GRATIS
                                    </span>
                                </a>

                                <a href="#agenda" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-3.5 hover:border-ripeMalinka transition block">
                                    <div class="w-10 h-10 rounded-xl bg-ripeMalinka/15 text-ripeMalinka flex items-center justify-center font-bold text-base shrink-0">
                                        <i class="fa-solid fa-bullhorn"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-heading text-xs font-bold text-darkEclipse truncate">Leadership & Public Speaking</h4>
                                        <p class="text-[11px] text-slate-500">Seminar Nasional • BEM Fakultas</p>
                                    </div>
                                    <span class="text-[10px] font-bold text-darkEclipse px-2 py-0.5 bg-white border border-slate-200 rounded-md shrink-0">
                                        GRATIS
                                    </span>
                                </a>

                                <a href="#agenda" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-3.5 hover:border-nakedNoodle transition block">
                                    <div class="w-10 h-10 rounded-xl bg-nakedNoodle/35 text-darkEclipse flex items-center justify-center font-bold text-base shrink-0">
                                        <i class="fa-solid fa-music"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-heading text-xs font-bold text-darkEclipse truncate">Pentas Seni Musik & Budaya</h4>
                                        <p class="text-[11px] text-slate-500">Festival Musik • UKM Seni</p>
                                    </div>
                                    <span class="text-[10px] font-bold text-ripeMalinka px-2 py-0.5 bg-white border border-slate-200 rounded-md shrink-0">
                                        HTM
                                    </span>
                                </a>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <span><i class="fa-regular fa-clock mr-1 text-slate-400"></i> Update setiap minggu</span>
                                <span class="font-semibold text-darkEclipse">150+ Ormawa Kampus</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="peran" class="bg-white border-y border-slate-200/80 py-16 sm:py-24">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-16">
                    <span class="font-heading text-xs font-bold uppercase tracking-wider text-ripeMalinka mb-2 block">Dua Sisi Kolaborasi</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-bold text-darkEclipse tracking-tight">Dirancang untuk Mahasiswa & Ormawa</h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2">Dua alur kerja terintegrasi yang memudahkan partisipasi maupun pengelolaan acara kampus.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

                    <div class="bg-surface rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6 relative overflow-hidden">
                        <div class="w-12 h-12 rounded-2xl bg-aquamarine/25 text-darkEclipse flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-aquamarine bg-darkEclipse px-3 py-1 rounded-full inline-block mb-3">Untuk Mahasiswa</span>
                            <h3 class="font-heading text-2xl font-bold text-darkEclipse">Kemudahan Eksplorasi & Tiket Digital</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mt-2">
                                Dapatkan akses terpusat ke seluruh kegiatan kampus tanpa harus mengecek puluhan poster di mading atau grup percakapan.
                            </p>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 border-t border-slate-200/70 pt-5">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-aquamarine mt-0.5 text-base"></i>
                                <span><strong>Pendaftaran 1-Klik:</strong> Terhubung otomatis dengan data diri mahasiswa (NPM, Program Studi, Semester).</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-aquamarine mt-0.5 text-base"></i>
                                <span><strong>E-Ticket Bebas Kertas:</strong> Simpan tiket langsung di smartphone untuk proses presensi instan di lokasi.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-aquamarine mt-0.5 text-base"></i>
                                <span><strong>Profil Mahasiswa Terpusat:</strong> Update kontak WhatsApp dan kelola riwayat kepesertaan acara kapan saja.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-surface rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6 relative overflow-hidden">
                        <div class="w-12 h-12 rounded-2xl bg-ripeMalinka/20 text-ripeMalinka flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-white bg-ripeMalinka px-3 py-1 rounded-full inline-block mb-3">Untuk Penyelenggara</span>
                            <h3 class="font-heading text-2xl font-bold text-darkEclipse">Manajemen Peserta & Publikasi Terpusat</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mt-2">
                                Wadah resmi bagi BEM, Himpunan Mahasiswa, dan UKM untuk mengumumkan kegiatan serta merekap peserta secara akurat.
                            </p>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 border-t border-slate-200/70 pt-5">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-ripeMalinka mt-0.5 text-base"></i>
                                <span><strong>Publikasi Acara Cepat:</strong> Terbitkan info seminar, workshop, dan kompetisi dengan format terstandarisasi.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-ripeMalinka mt-0.5 text-base"></i>
                                <span><strong>Rekapitulasi Valid:</strong> Hindari data ganda karena pendaftar terverifikasi dengan data akun kampus resmi.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-ripeMalinka mt-0.5 text-base"></i>
                                <span><strong>Dashboard Penyelenggara:</strong> Pantau kuota peserta dan koordinasi kehadiran dengan efisien.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        <section id="fitur" class="py-16 sm:py-24 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="font-heading text-xs font-bold uppercase tracking-wider text-darkEclipse mb-2 block">Fitur Inti</span>
                <h2 class="font-heading text-3xl sm:text-4xl font-bold text-darkEclipse tracking-tight">Teknologi Praktis untuk Ekosistem Kampus</h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2">Menyederhanakan administrasi kegiatan agar panitia dan mahasiswa fokus pada substansi acara.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-sm hover:border-aquamarine transition duration-200 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-aquamarine/25 text-darkEclipse flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <h3 class="font-heading text-lg font-bold text-darkEclipse">Katalog Acara Terpadu</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Pencarian cepat berdasarkan bidang minat: teknologi informasi, kewirausahaan, seni budaya, riset ilmiah, hingga kepanitiaan.
                    </p>
                </div>

                <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-sm hover:border-ripeMalinka transition duration-200 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-ripeMalinka/20 text-ripeMalinka flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <h3 class="font-heading text-lg font-bold text-darkEclipse">Tiket & Presensi Digital</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Penerbitan e-ticket otomatis begitu pendaftaran dikonfirmasi. Memudahkan validasi kehadiran di pintu masuk ruang acara.
                    </p>
                </div>

                <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-sm hover:border-nakedNoodle transition duration-200 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-nakedNoodle/35 text-darkEclipse flex items-center justify-center text-xl font-bold">
                        <i class="fa-regular fa-id-card"></i>
                    </div>
                    <h3 class="font-heading text-lg font-bold text-darkEclipse">Profil Mahasiswa Mandiri</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Kelola data diri, NPM, jurusan, semester, nomor kontak, serta foto profil mahasiswa secara mandiri dan aman.
                    </p>
                </div>
            </div>
        </section>


        <section id="agenda" class="bg-white border-t border-slate-200/80 py-16 sm:py-24">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
                    <div>
                        <span class="font-heading text-xs font-bold uppercase tracking-wider text-ripeMalinka mb-1 block">Agenda Terkini</span>
                        <h2 class="font-heading text-3xl sm:text-4xl font-bold text-darkEclipse tracking-tight">Rekomendasi Acara Kampus</h2>
                    </div>
                    <div class="mt-4 sm:mt-0 text-xs font-medium text-slate-500">
                        Masuk dengan akun terdaftar untuk mengikuti acara.
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">

                    <div class="bg-surface rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full bg-aquamarine/25 text-darkEclipse">
                                    Workshop
                                </span>
                                <span class="text-xs font-bold text-emerald-600">Gratis</span>
                            </div>
                            <div class="p-6 space-y-3">
                                <h4 class="font-heading font-bold text-lg text-darkEclipse leading-snug">Fullstack Web App Development with Laravel</h4>
                                <div class="space-y-1.5 text-xs text-slate-500">
                                    <div><i class="fa-regular fa-calendar mr-2 text-ripeMalinka"></i> Sabtu, 14 Nov 2026</div>
                                    <div><i class="fa-solid fa-location-dot mr-2 text-darkEclipse"></i> Lab Komputer Terpadu</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            @auth
                                <a href="{{ route('dashboard') }}" class="block text-center w-full py-2.5 rounded-xl text-xs font-bold bg-darkEclipse hover:bg-slate-800 text-white transition">Lihat Detail Acara</a>
                            @else
                                <a href="{{ route('login') }}" class="block text-center w-full py-2.5 rounded-xl text-xs font-bold bg-darkEclipse hover:bg-slate-800 text-white transition">Masuk untuk Ikut Acara</a>
                            @endauth
                        </div>
                    </div>

                    <div class="bg-surface rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full bg-ripeMalinka/20 text-ripeMalinka">
                                    Seminar
                                </span>
                                <span class="text-xs font-bold text-emerald-600">Gratis</span>
                            </div>
                            <div class="p-6 space-y-3">
                                <h4 class="font-heading font-bold text-lg text-darkEclipse leading-snug">Pemanfaatan AI untuk Produktivitas Riset</h4>
                                <div class="space-y-1.5 text-xs text-slate-500">
                                    <div><i class="fa-regular fa-calendar mr-2 text-ripeMalinka"></i> Kamis, 19 Nov 2026</div>
                                    <div><i class="fa-solid fa-location-dot mr-2 text-darkEclipse"></i> Auditorium Utama</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            @auth
                                <a href="{{ route('dashboard') }}" class="block text-center w-full py-2.5 rounded-xl text-xs font-bold bg-darkEclipse hover:bg-slate-800 text-white transition">Lihat Detail Acara</a>
                            @else
                                <a href="{{ route('login') }}" class="block text-center w-full py-2.5 rounded-xl text-xs font-bold bg-darkEclipse hover:bg-slate-800 text-white transition">Masuk untuk Ikut Acara</a>
                            @endauth
                        </div>
                    </div>

                    <div class="bg-surface rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full bg-nakedNoodle/35 text-darkEclipse">
                                    Seni & Musik
                                </span>
                                <span class="text-xs font-bold text-darkEclipse">Rp 25.000</span>
                            </div>
                            <div class="p-6 space-y-3">
                                <h4 class="font-heading font-bold text-lg text-darkEclipse leading-snug">Malam Apresiasi Karya Seni Mahasiswa</h4>
                                <div class="space-y-1.5 text-xs text-slate-500">
                                    <div><i class="fa-regular fa-calendar mr-2 text-ripeMalinka"></i> Jumat, 27 Nov 2026</div>
                                    <div><i class="fa-solid fa-location-dot mr-2 text-darkEclipse"></i> Open Stage Mahasiswa</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            @auth
                                <a href="{{ route('dashboard') }}" class="block text-center w-full py-2.5 rounded-xl text-xs font-bold bg-darkEclipse hover:bg-slate-800 text-white transition">Lihat Detail Acara</a>
                            @else
                                <a href="{{ route('login') }}" class="block text-center w-full py-2.5 rounded-xl text-xs font-bold bg-darkEclipse hover:bg-slate-800 text-white transition">Masuk untuk Beli Tiket</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="bg-darkEclipse text-white py-16 sm:py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-10">
                <div class="space-y-3 text-center md:text-left max-w-xl">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents Logo" class="h-9 w-auto object-contain mx-auto md:mx-0 bg-white rounded-lg p-1.5 mb-2">
                    <h3 class="font-heading text-3xl font-bold tracking-tight">Siap mengeksplorasi kegiatan kampus?</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Bergabunglah bersama ribuan mahasiswa dan puluhan organisasi kampus yang telah memanfaatkan ekosistem digital Univents.
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('profile.show') }}" class="px-7 py-3.5 rounded-xl text-sm font-bold bg-aquamarine text-darkEclipse hover:bg-[#31c4ad] transition shadow-md">
                            Buka Profil Saya
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-7 py-3.5 rounded-xl text-sm font-bold bg-aquamarine text-darkEclipse hover:bg-[#31c4ad] transition shadow-md">
                            Daftar Akun Baru
                        </a>
                    @endauth
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-white border-t border-slate-200 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents Logo" class="h-7 w-auto object-contain">
                <span class="text-xs text-slate-500">&copy; {{ date('Y') }} Univents. Official Campus Event Space.</span>
            </div>
            <div class="flex items-center gap-6 text-xs text-slate-500 font-medium">
                <a href="#peran" class="hover:text-darkEclipse transition">Alur Layanan</a>
                <a href="#fitur" class="hover:text-darkEclipse transition">Fitur Platform</a>
                <a href="#agenda" class="hover:text-darkEclipse transition">Agenda Acara</a>
                <a href="#tentang" class="hover:text-darkEclipse transition">Tentang Kami</a>
            </div>
        </div>
    </footer>

</body>
</html>
