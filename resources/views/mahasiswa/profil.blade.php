<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Univents</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#162945',
                            coral: '#F45D69',
                            cyan: '#39D9C1',
                            amber: '#FCCC6B',
                            bg: '#F8FAFC'
                        }
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
    </style>
</head>

<body class="bg-brand-bg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight text-white hidden sm:inline">Uni<span class="text-brand-cyan">vents</span></span>
                </a>

                <div class="hidden sm:block h-5 w-[1px] bg-white/20"></div>

                <nav class="hidden sm:flex items-center gap-3 text-xs font-semibold text-white/80">
                    <!-- <a href="{{ route('dashboard') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                    <span class="text-white/30">/</span> -->
                    <span class="text-brand-cyan">Profil Mahasiswa</span>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <span class="hidden md:inline text-xs font-semibold text-white/80">
                    {{ Auth::user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-white/10 text-white hover:bg-brand-coral transition border border-white/10">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        <aside class="w-full md:w-64 shrink-0 space-y-3">
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Navigasi Akun</div>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy transition">
                    <i class="fa-solid fa-house w-4 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy transition">
                    <i class="fa-solid fa-compass w-4 text-center"></i>
                    <span>Katalog Acara</span>
                </a>

                <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold bg-brand-navy text-white shadow-sm transition">
                    <i class="fa-solid fa-user w-4 text-center text-brand-cyan"></i>
                    <span>Profil Mahasiswa</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-brand-coral hover:bg-rose-50 transition text-left">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>

            <div class="bg-brand-navy text-white p-5 rounded-2xl border border-slate-800 shadow-sm text-center">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-10 mx-auto object-contain bg-white rounded-lg p-1.5 mb-3">
                <h4 class="text-xs font-bold text-brand-cyan uppercase tracking-wider mb-1">Univents Mahasiswa</h4>
                <p class="text-[11px] text-slate-300 leading-relaxed">
                    Pastikan nama dan NPM Anda akurat untuk kemudahan validasi sertifikat dan e-tiket acara.
                </p>
            </div>
        </aside>

        <main class="flex-1 space-y-6">

            @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @if(session('success_password'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </div>
                    <span class="font-medium">{{ session('success_password') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 rounded-full bg-brand-coral text-white flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid fa-exclamation text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold mb-1">Periksa kembali data Anda:</h4>
                        <ul class="list-disc list-inside space-y-0.5 text-xs">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-6">
                <div class="relative">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-brand-navy text-white flex items-center justify-center text-3xl font-extrabold shadow-md border-2 border-slate-100">
                        @if(!empty($user->avatar) && file_exists(public_path('uploads/profiles/' . $user->avatar)))
                        <img src="{{ asset('uploads/profiles/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                        <span class="text-brand-cyan">{{ strtoupper(substr($user->name ?? 'M', 0, 2)) }}</span>
                        @endif
                    </div>
                    <label for="foto_profil" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-brand-cyan text-brand-navy flex items-center justify-center cursor-pointer shadow-md hover:scale-105 transition" title="Ganti Foto">
                        <i class="fa-solid fa-camera text-xs"></i>
                    </label>
                </div>

                <div class="text-center sm:text-left space-y-1 flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h2 class="text-2xl font-extrabold text-brand-navy">{{ $user->name }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-cyan/20 text-brand-navy self-center sm:self-auto border border-brand-cyan/30">
                            Mahasiswa
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 font-medium">
                        <span class="font-semibold text-slate-700">NPM:</span> {{ $user->npm ?? 'Belum diatur' }}
                        <span class="mx-2 text-slate-300">|</span>
                        <span>{{ $user->major ?? 'Jurusan belum diisi' }}</span>
                        @if($user->semester)
                        <span class="mx-2 text-slate-300">|</span>
                        <span>Semester {{ $user->semester }}</span>
                        @endif
                    </p>
                    <p class="text-xs text-slate-400">
                        <i class="fa-regular fa-envelope mr-1"></i> {{ $user->email }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-brand-navy flex items-center gap-2">
                        <i class="fa-regular fa-id-card text-brand-cyan"></i>
                        Informasi Data Diri
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Perbarui profil dan kontak mahasiswa Anda.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Unggah Foto Profil Baru</label>
                        <input
                            type="file"
                            name="foto_profil"
                            id="foto_profil"
                            accept="image/png, image/jpeg, image/jpg"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-navy file:text-white hover:file:bg-[#2563EB] cursor-pointer">
                        <span class="text-[11px] text-slate-400 mt-1 block">Format: JPG, JPEG, atau PNG (Maks. 2MB).</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">NPM</label>
                            <input
                                type="text"
                                value="{{ $user->npm ?? '-' }}"
                                readonly
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 text-sm cursor-not-allowed">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">NPM dikunci sesuai identitas registrasi.</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Mahasiswa</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp / Telepon</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Contoh: 081234567890"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Program Studi</label>
                            <input
                                type="text"
                                name="major"
                                value="{{ old('major', $user->major) }}"
                                placeholder="Contoh: Ilmu Komputer"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Semester</label>
                            <input
                                type="number"
                                name="semester"
                                min="1"
                                max="14"
                                value="{{ old('semester', $user->semester) }}"
                                placeholder="Contoh: 3"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-brand-navy text-white hover:bg-brand-navy/90 transition shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-brand-navy flex items-center gap-2">
                        <i class="fa-solid fa-key text-brand-amber"></i>
                        Ganti Kata Sandi
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Perbarui kata sandi akun Anda secara berkala.</p>
                </div>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                            <input
                                type="password"
                                name="current_password"
                                required
                                placeholder="Masukkan kata sandi lama"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                            <input
                                type="password"
                                name="password"
                                required
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                placeholder="Ulangi kata sandi baru"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 transition">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

</body>

</html>