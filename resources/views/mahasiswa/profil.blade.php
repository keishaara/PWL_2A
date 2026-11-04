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

     @include('mahasiswa.partials.header', ['title' => 'Profil Mahasiswa'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('mahasiswa.partials.sidebar', ['active' => 'profile'])

        <main class="flex-1 min-w-0">
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
    @include('mahasiswa.partials.footer')
</body>

</html>