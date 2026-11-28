<!DOCTYPE html>
<html lang="id">
<head>
    @include('organisasi.partials.head')
    <title>Profil Organisasi - Univents</title>
</head>
<body class="bg-brand-warmBg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('organisasi.partials.header', ['title' => 'Profil Organisasi'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'profile'])

        <main class="flex-1 min-w-0">

            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-brand-navy">Profil Organisasi</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola identitas publik, logo resmi, kontak narahubung, serta kredensial akun organisasi Anda.</p>
            </div>

            @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-xs sm:text-sm shadow-sm mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @if(session('success_password'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-xs sm:text-sm shadow-sm mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </div>
                    <span class="font-semibold">{{ session('success_password') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @if(isset($errors) && $errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm shadow-sm mb-6">
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 rounded-full bg-brand-coral text-white flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid fa-exclamation text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold mb-1">Periksa kembali data Anda:</h4>
                        <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/90 shadow-sm flex flex-col sm:flex-row items-center gap-6 mb-6">
                <div class="relative group">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-brand-navy text-white flex items-center justify-center text-3xl font-extrabold shadow-md border-2 border-slate-100">
                        @if(!empty($user->avatar) && file_exists(public_path('uploads/profiles/' . $user->avatar)))
                        <img id="avatarPreview" src="{{ asset('uploads/profiles/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                        <img id="avatarPreview" class="w-full h-full object-cover hidden" alt="Preview">
                        <span id="avatarPlaceholder" class="text-brand-blue">{{ strtoupper(substr($user->name ?? 'O', 0, 2)) }}</span>
                        @endif
                    </div>
                    <label for="foto_profil" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-brand-blue hover:bg-[#1a7fe8] text-white flex items-center justify-center cursor-pointer shadow-md hover:scale-105 transition" title="Pilih Foto / Logo Baru">
                        <i class="fa-solid fa-camera text-xs"></i>
                    </label>
                </div>

                <div class="text-center sm:text-left space-y-1 flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h2 class="text-xl font-extrabold text-brand-navy">{{ $user->name }}</h2>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-brand-blue border border-blue-200 self-center sm:self-auto">
                            <i class="fa-solid fa-shield-halved text-[9px]"></i> Penyelenggara Resmi
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">
                        Akun Pengelola Kegiatan & Ormawa Kampus Univents
                    </p>
                    <div class="flex items-center justify-center sm:justify-start gap-4 text-xs text-slate-400 pt-1 flex-wrap">
                        <span><i class="fa-regular fa-envelope mr-1 text-slate-400"></i> {{ $user->email }}</span>
                        @if($user->phone)
                        <span><i class="fa-brands fa-whatsapp mr-1 text-emerald-500"></i> {{ $user->phone }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm mb-6">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-base font-bold text-brand-navy flex items-center gap-2">
                        <i class="fa-regular fa-id-card text-brand-blue"></i>
                        Informasi Data Diri & Kontak Organisasi
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui nama organisasi, email resmi, dan kontak narahubung.</p>
                </div>

                <form method="POST" action="{{ route('organisasi.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-200/80">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Unggah Foto Profil / Logo Organisasi</label>
                        <input
                            type="file"
                            name="foto_profil"
                            id="foto_profil"
                            accept="image/png, image/jpeg, image/jpg"
                            onchange="previewImage(this)"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-navy file:text-white hover:file:bg-[#121E38] cursor-pointer">
                        <span class="text-[11px] text-slate-400 mt-1.5 block">Format yang didukung: JPG, JPEG, atau PNG (Maksimal 2 MB).</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Organisasi / Lembaga <span class="text-rose-500">*</span></label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-brand-navy font-semibold focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Narahubung Resmi <span class="text-rose-500">*</span></label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-brand-navy font-semibold focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp / Kontak Narahubung</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Contoh: 081234567890"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-brand-navy font-semibold focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-bold bg-brand-blue hover:bg-[#1a7fe8] text-white transition shadow-md shadow-blue-500/20">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-base font-bold text-brand-navy flex items-center gap-2">
                        <i class="fa-solid fa-key text-amber-500"></i>
                        Ganti Kata Sandi
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui kata sandi akun Anda secara berkala untuk menjaga keamanan akses.</p>
                </div>

                <form method="POST" action="{{ route('organisasi.profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Saat Ini <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    required
                                    placeholder="Masukkan kata sandi lama Anda"
                                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-brand-navy focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                                <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-navy text-xs">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="new_password"
                                    name="password"
                                    required
                                    placeholder="Minimal 8 karakter"
                                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-brand-navy focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                                <button type="button" onclick="togglePasswordVisibility('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-navy text-xs">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    placeholder="Ulangi kata sandi baru"
                                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-brand-navy focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy transition">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-navy text-xs">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-bold bg-brand-navy hover:bg-[#121E38] text-white transition shadow-sm">
                            <i class="fa-solid fa-lock"></i>
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    @include('organisasi.partials.footer')

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('avatarPreview');
                    const placeholder = document.getElementById('avatarPlaceholder');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function togglePasswordVisibility(fieldId, button) {
            const field = document.getElementById(fieldId);
            const icon = button.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>