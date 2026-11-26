<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Univents</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkEclipse: '#14213D',
                        cyberNavy: '#121E38',
                        electricBlue: '#1E90FF',
                        ripeMalinka: '#FF6B5B',
                        surface: '#F8F6F1'
                    },
                    fontFamily: {
                        jakarta: ['"Plus Jakarta Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F6F1;
        }

        .form-input {
            width: 100%;
            padding: 0.6rem 2.25rem 0.6rem 0.875rem;
            font-size: 0.8125rem;
            background-color: #F8F6F1;
            border: 1px solid #E2E8F0;
            border-radius: 0.75rem;
            color: #14213D;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            background-color: #FFFFFF;
            border-color: #1E90FF;
            box-shadow: 0 0 0 3px rgba(30, 144, 255, 0.15);
        }

        .form-input::placeholder {
            color: #94A3B8;
        }

        .form-input.field-error {
            border-color: #FF6B5B;
            background-color: #FFF5F5;
        }

        select.form-input {
            appearance: none;
            -webkit-appearance: none;
        }

        select.form-input option {
            color: #14213D;
            background: #FFFFFF;
        }

        @view-transition {
            navigation: auto;
        }

        .photo-panel {
            view-transition-name: photo;
        }

        ::view-transition-group(photo) {
            animation-duration: 0.7s;
            animation-timing-function: cubic-bezier(0.77, 0, 0.18, 1);
        }

        ::view-transition-old(photo),
        ::view-transition-new(photo) {
            height: 100%;
            object-fit: cover;
            overflow: clip;
        }

        ::view-transition-group(root) {
            animation-duration: 0.4s;
        }

        @media (prefers-reduced-motion: reduce) {
            ::view-transition-group(*),
            ::view-transition-old(*),
            ::view-transition-new(*) {
                animation: none !important;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-3 sm:p-5 bg-[#F8F6F1] text-[#14213D]">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden flex flex-col md:flex-row-reverse md:h-[560px]">

        <!-- Right (in reverse): Photo Panel with Campus Life (50% width) -->
        <div class="photo-panel relative w-full md:w-1/2 min-h-[260px] md:min-h-full flex flex-col justify-between p-8 sm:p-10 text-white overflow-hidden bg-[#121E38]">

            <img src="https://images.unsplash.com/photo-1781038507661-06501ddcdc90?q=80&w=1373&auto=format&fit=crop"
                class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-100" alt="Kampus 1">

            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1373&auto=format&fit=crop"
                class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0" alt="Kampus 2">

            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1373&auto=format&fit=crop"
                class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0" alt="Kampus 3">

            <div class="absolute inset-0 bg-gradient-to-t from-[#14213D]/95 via-[#121E38]/80 to-[#14213D]/70 backdrop-blur-[1px]"></div>

            <div class="relative z-10 flex items-center gap-2 text-[11px] font-semibold tracking-widest uppercase text-white/80">
                <span class="w-2 h-2 rounded-full bg-[#1E90FF]"></span>
                Official Campus Event Space
            </div>

            <div class="relative z-10 my-auto text-center py-6">
                <p class="text-xl sm:text-2xl font-bold tracking-wider leading-relaxed text-white drop-shadow-md">
                    EXPERIENCE THE MOMENTS THAT SHAPE YOUR CAMPUS LIFE
                </p>
                <p class="text-xs text-white/70 mt-3 font-normal">
                    Pusat kolaborasi & kegiatan kampus terintegrasi
                </p>
            </div>

            <div class="relative z-10 text-[11px] text-white/50">
                &copy; {{ date('Y') }} Univents. Modern Campus Ecosystem.
            </div>
        </div>

        <div class="w-full md:w-1/2 bg-white p-7 sm:p-9 md:p-10 flex flex-col justify-between">

            <div class="flex flex-col items-center justify-center text-center">
                <a href="{{ url('/') }}" class="inline-block transition hover:opacity-90">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-10 w-auto object-contain">
                </a>
                <h2 class="mt-2 text-lg sm:text-xl font-bold text-[#14213D] tracking-tight">Buat Akun Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar untuk mulai jelajahi kegiatan kampus</p>
            </div>

            <div class="my-auto py-2">

                @php
                $mismatch = collect($errors->get('password'))->contains(fn ($m) => str_contains($m, 'tidak sama'));
                @endphp

                <form id="register-form" action="{{ route('register.store') }}" method="POST" novalidate class="flex flex-col gap-2.5">
                    @csrf

                    <div class="relative">
                        <select id="tipe" name="tipe" required class="{{ ($errors->has('tipe')) ? 'field-error' : '' }} form-input">
                            <option value="">Pilih Jenis Akun</option>
                            <option value="mahasiswa" {{ old('tipe') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="organisasi" {{ old('tipe') == 'organisasi' ? 'selected' : '' }}>Organisasi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-3 text-slate-400 text-xs pointer-events-none"></i>
                    </div>

                    <div class="relative">
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required maxlength="255"
                            autocomplete="name" placeholder="Nama lengkap"
                            class="{{ ($errors->has('nama')) ? 'field-error' : '' }} form-input">
                        <i class="fa-regular fa-user absolute right-3.5 top-3 text-slate-400 text-xs pointer-events-none"></i>
                    </div>

                    <div id="mhs-fields" class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div class="relative">
                            <input type="text" id="npm" name="npm" value="{{ old('npm') }}" inputmode="numeric"
                                maxlength="20" placeholder="NPM"
                                class="{{ ($errors->has('npm')) ? 'field-error' : '' }} form-input">
                            <i class="fa-regular fa-id-card absolute right-3.5 top-3 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                        <div class="relative">
                            <input type="text" id="program_studi" name="program_studi" value="{{ old('program_studi') }}"
                                maxlength="255" placeholder="Program Studi"
                                class="{{ ($errors->has('program_studi')) ? 'field-error' : '' }} form-input">
                            <i class="fa-solid fa-graduation-cap absolute right-3.5 top-3 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                autocomplete="email" placeholder="Email address"
                                class="{{ ($errors->has('email')) ? 'field-error' : '' }} form-input">
                            <i class="fa-regular fa-envelope absolute right-3.5 top-3 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                        <div class="relative">
                            <input type="tel" id="wa" name="wa" value="{{ old('wa') }}" required maxlength="20"
                                autocomplete="tel" placeholder="WhatsApp (08xx)"
                                class="{{ ($errors->has('wa')) ? 'field-error' : '' }} form-input">
                            <i class="fa-brands fa-whatsapp absolute right-3.5 top-3 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div class="relative">
                            <input type="password" id="password" name="password" required minlength="8"
                                autocomplete="new-password" placeholder="Password (min. 8)"
                                class="{{ ($errors->has('password')) ? 'field-error' : '' }} form-input">
                            <i id="eye-password"
                                class="fa-solid fa-eye absolute right-3.5 top-3 text-slate-400 hover:text-slate-600 text-xs cursor-pointer"
                                onclick="togglePassword('password', 'eye-password')"></i>
                        </div>
                        <div class="relative">
                            <input type="password" id="konfirmasi_password" name="konfirmasi_password" required
                                autocomplete="new-password" placeholder="Konfirmasi password"
                                class="{{ ($errors->has('konfirmasi_password') || $mismatch) ? 'field-error' : '' }} form-input">
                            <i id="eye-confirm"
                                class="fa-solid fa-eye absolute right-3.5 top-3 text-slate-400 hover:text-slate-600 text-xs cursor-pointer"
                                onclick="togglePassword('konfirmasi_password', 'eye-confirm')"></i>
                        </div>
                    </div>

                    <div class="min-h-[26px]">
                        @if ($errors->any())
                        <div id="server-error" class="flex items-start gap-1.5 rounded-lg bg-rose-50 border border-rose-200 px-3 py-1.5 text-xs text-rose-700">
                            <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 shrink-0"></i>
                            <span class="line-clamp-1">{{ $errors->first() }}</span>
                        </div>
                        @endif

                        <div id="client-error" style="display:none" class="flex items-start gap-1.5 rounded-lg bg-rose-50 border border-rose-200 px-3 py-1.5 text-xs text-rose-700">
                            <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 shrink-0"></i>
                            <span id="client-error-text" class="line-clamp-1"></span>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full py-3 px-6 rounded-xl bg-[#1E90FF] hover:bg-[#1877d2] text-white font-bold text-xs uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-[#1E90FF]/25 transition duration-200">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center text-xs text-slate-500 pt-1">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-[#1E90FF] hover:underline ml-1">
                    Masuk di sini
                </a>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        const tipeSelect = document.getElementById('tipe');
        const namaInput = document.getElementById('nama');
        const mhsFields = document.getElementById('mhs-fields');
        const npmInput = document.getElementById('npm');
        const prodiInput = document.getElementById('program_studi');

        function updateFields() {
            const isMahasiswa = tipeSelect.value === 'mahasiswa';
            const isOrganisasi = tipeSelect.value === 'organisasi';

            mhsFields.style.display = isOrganisasi ? 'none' : 'grid';
            [npmInput, prodiInput].forEach(input => {
                input.disabled = isOrganisasi;
                input.required = isMahasiswa;
                if (isOrganisasi) input.value = '';
            });

            namaInput.placeholder = isOrganisasi ? 'Nama organisasi (contoh: BEM Fakultas)' : 'Nama lengkap';
        }

        tipeSelect.addEventListener('change', updateFields);
        updateFields();

        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('konfirmasi_password');
        const MISMATCH = 'Password dan konfirmasi password belum sama.';
        let mismatchShown = false;

        function clearFieldMarks() {
            document.querySelectorAll('.field-error').forEach(el => el.classList.remove('field-error'));
        }

        function showClientError(message, field) {
            clearFieldMarks();
            if (field) field.classList.add('field-error');
            const serverError = document.getElementById('server-error');
            if (serverError) serverError.style.display = 'none';
            document.getElementById('client-error-text').textContent = message;
            document.getElementById('client-error').style.display = 'flex';
        }

        function hideClientError() {
            clearFieldMarks();
            document.getElementById('client-error').style.display = 'none';
        }

        function checkPassword() {
            const same = confirmInput.value === '' || passwordInput.value === confirmInput.value;
            if (!same) {
                showClientError(MISMATCH, confirmInput);
                mismatchShown = true;
            } else if (mismatchShown) {
                hideClientError();
                mismatchShown = false;
            }
        }

        passwordInput.addEventListener('input', checkPassword);
        confirmInput.addEventListener('input', checkPassword);

        const registerForm = document.getElementById('register-form');

        function firstError() {
            const v = id => document.getElementById(id).value.trim();
            const isMahasiswa = tipeSelect.value === 'mahasiswa';

            if (!tipeSelect.value) return ['Pilih jenis akun terlebih dahulu.', tipeSelect];
            if (!v('nama')) return ['Nama wajib diisi.', namaInput];
            if (!v('email')) return ['Email wajib diisi.', document.getElementById('email')];
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v('email'))) return ['Format email tidak valid.', document.getElementById('email')];
            if (isMahasiswa && !v('npm')) return ['NPM wajib diisi untuk mahasiswa.', npmInput];
            if (isMahasiswa && !v('program_studi')) return ['Program studi wajib diisi untuk mahasiswa.', prodiInput];
            if (!v('wa')) return ['Nomor WhatsApp wajib diisi.', document.getElementById('wa')];
            if (!/^(\+62|62|0)8[0-9]{8,12}$/.test(v('wa'))) return ['Format nomor WhatsApp tidak valid (contoh: 081234567890).', document.getElementById('wa')];
            if (!passwordInput.value) return ['Password wajib diisi.', passwordInput];
            if (passwordInput.value.length < 8) return ['Password minimal 8 karakter.', passwordInput];
            if (!confirmInput.value) return ['Konfirmasi password wajib diisi.', confirmInput];
            if (passwordInput.value !== confirmInput.value) return ['Password dan konfirmasi password tidak sama.', confirmInput];
            return null;
        }

        registerForm.addEventListener('input', e => {
            if (e.target === confirmInput && mismatchShown) return;
            e.target.classList.remove('field-error');
        });
        registerForm.addEventListener('change', e => e.target.classList.remove('field-error'));

        registerForm.addEventListener('submit', function(e) {
            const error = firstError();
            if (!error) return;

            e.preventDefault();
            mismatchShown = false;
            showClientError(error[0], error[1]);
            error[1].focus();
        });

        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide-img');

        setInterval(() => {
            if (slides.length > 0) {
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');

                currentSlide = (currentSlide + 1) % slides.length;

                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
            }
        }, 4000);
    </script>

</body>

</html>
