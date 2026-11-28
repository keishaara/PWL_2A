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
                            navy: '#14213D',
                            coral: '#FF6B5B',
                            blue: '#1E90FF',
                            cyber: '#121E38',
                            warmBg: '#F8F6F1',
                            amber: '#FCCC6B'
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
            background-color: #F8F6F1;
        }
    </style>
</head>

<body class="bg-brand-warmBg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('organisasi.partials.header', ['title' => 'Profil Organisasi'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('organisasi.partials.sidebar', ['active' => 'profile'])

        <main class="flex-1 min-w-0">
            @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm shadow-sm mb-6">
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
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm shadow-sm mb-6">
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
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm mb-6">
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

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-6 mb-6">
                <div class="relative">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-brand-navy text-white flex items-center justify-center text-3xl font-extrabold shadow-md border-2 border-slate-100">
                        @if(!empty($user->avatar) && file_exists(public_path('uploads/profiles/' . $user->avatar)))
                        <img src="{{ asset('uploads/profiles/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                        <span class="text-brand-blue">{{ strtoupper(substr($user->name ?? 'O', 0, 2)) }}</span>
                        @endif
                    </div>
                    <label for="foto_profil" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-brand-blue text-white flex items-center justify-center cursor-pointer shadow-md hover:scale-105 transition" title="Ganti Foto">
                        <i class="fa-solid fa-camera text-xs"></i>
                    </label>
                </div>

                <div class="text-center sm:text-left space-y-1 flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h2 class="text-2xl font-extrabold text-brand-navy">{{ $user->name }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#1E90FF]/20 text-[#1E90FF] self-center sm:self-auto border border-[#1E90FF]/30">
                            Organisasi
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 font-medium">
                        <span class="font-semibold text-slate-700">Penyelenggara Acara Kampus</span>
                    </p>
                    <p class="text-xs text-slate-400">
                        <i class="fa-regular fa-envelope mr-1"></i> {{ $user->email }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm mb-6">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-brand-navy flex items-center gap-2">
                        <i class="fa-regular fa-id-card text-brand-blue"></i>
                        Informasi Data Diri
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Perbarui profil dan kontak organisasi Anda.</p>
                </div>

                <form method="POST" action="{{ route('organisasi.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Unggah Foto Profil / Logo Baru</label>
                        <input
                            type="file"
                            name="foto_profil"
                            id="foto_profil"
                            accept="image/png, image/jpeg, image/jpg"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-navy file:text-white hover:file:bg-[#2563EB] cursor-pointer">
                        <span class="text-[11px] text-slate-400 mt-1 block">Format: JPG, JPEG, atau PNG (Maks. 2MB).</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Organisasi</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Organisasi</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp / Kontak Narahubung</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Contoh: 081234567890"
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

                <form method="POST" action="{{ route('organisasi.profile.password') }}" class="space-y-4">
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
    @include('organisasi.partials.footer')
</body>

</html>
