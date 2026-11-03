<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Univents</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .page-bg {
            background: linear-gradient(135deg, #162945 0%, #162945 38%, #F1F5F9 38%, #F1F5F9 100%);
        }

        .minimal-input {
            background: transparent;
            border: none;
            border-bottom: 1.5px solid rgba(255, 255, 255, 0.25);
            outline: none;
            color: #ffffff;
            transition: border-color 0.2s ease;
        }

        .minimal-input:focus {
            border-bottom-color: #39D9C1;
        }

        .minimal-input.field-error,
        .minimal-input.field-error:focus {
            border-bottom-color: #F45D69;
        }

        .minimal-input::placeholder {
            color: rgba(255, 255, 255, 0.45);
        }

        select.minimal-input option {
            color: #162945;
            background: #ffffff;
        }

        select.minimal-input {
            appearance: none;
            -webkit-appearance: none;
        }

        .brand-bracket {
            position: relative;
            display: inline-block;
            padding: 8px 18px;
        }

        .brand-bracket::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 8px;
            border-left: 2px solid #ffffff;
            border-top: 2px solid #ffffff;
            border-bottom: 2px solid #ffffff;
        }

        .brand-bracket::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 8px;
            border-right: 2px solid #ffffff;
            border-top: 2px solid #ffffff;
            border-bottom: 2px solid #ffffff;
        }

        /* transisi geser foto antara halaman login dan register */
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
            animation-duration: 0.2s;
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

<body class="page-bg min-h-screen flex items-center justify-center p-3 sm:p-4">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row-reverse md:h-[536px]">

        {{-- panel foto (di kanan pada layar md ke atas) --}}
        <div class="photo-panel relative w-full md:w-1/2 min-h-[220px] md:min-h-full flex flex-col justify-between p-8 sm:p-10 text-white overflow-hidden">
            <img
                src="https://images.unsplash.com/photo-1781038507661-06501ddcdc90?q=80&w=1373&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D"
                alt="Kampus"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#162945]/60 backdrop-blur-[2px]"></div>

            <div class="relative z-10 text-[11px] font-semibold tracking-widest uppercase text-white/75">
                Official Campus Event Space
            </div>

            <div class="relative z-10 my-auto text-center py-6">
                <p class="text-xl sm:text-2xl font-bold tracking-wider leading-relaxed text-white drop-shadow-md">
                    EXPERIENCE THE MOMENTS THAT SHAPE YOUR CAMPUS LIFE
                </p>
            </div>
        </div>

        {{-- panel form daftar (di kiri pada layar md ke atas) --}}
        <div class="w-full md:w-1/2 bg-[#162945] p-8 sm:px-10 sm:pt-12 sm:pb-8 flex flex-col text-white">

            <div class="text-center pt-2">
                <div class="brand-bracket">
                    <span class="text-base sm:text-lg font-bold tracking-[0.25em] text-white">
                        UNIVENTS
                    </span>
                </div>
            </div>

            <div class="mt-4 flex-1 flex flex-col">

                @php
                    $mismatch = collect($errors->get('password'))->contains(fn ($m) => str_contains($m, 'tidak sama'));
                @endphp

                <form id="register-form" action="{{ route('register.store') }}" method="POST" novalidate class="flex flex-1 flex-col gap-3">
                    @csrf

                    {{-- Jenis akun --}}
                    <div class="relative">
                        <select id="tipe" name="tipe" required class="{{ ($errors->has('tipe')) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                            <option value="">Daftar sebagai</option>
                            <option value="mahasiswa" {{ old('tipe') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="organisasi" {{ old('tipe') == 'organisasi' ? 'selected' : '' }}>Organisasi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-2 top-3 text-white/50 text-xs pointer-events-none"></i>
                    </div>

                    {{-- nama (placeholder berubah sesuai jenis akun) --}}
                    <div class="relative">
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required maxlength="255"
                            autocomplete="name" placeholder="Nama lengkap"
                            class="{{ ($errors->has('nama')) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                        <i class="fa-regular fa-user absolute right-2 top-3 text-white/50 text-xs"></i>
                    </div>

                    {{-- NPM + program studi (hanya untuk mahasiswa) --}}
                    <div id="mhs-fields" class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">
                        <div class="relative">
                            <input type="text" id="npm" name="npm" value="{{ old('npm') }}" inputmode="numeric"
                                maxlength="20" placeholder="NPM"
                                class="{{ ($errors->has('npm')) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                            <i class="fa-regular fa-id-card absolute right-2 top-3 text-white/50 text-xs"></i>
                        </div>
                        <div class="relative">
                            <input type="text" id="program_studi" name="program_studi" value="{{ old('program_studi') }}"
                                maxlength="255" placeholder="Program studi"
                                class="{{ ($errors->has('program_studi')) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                            <i class="fa-solid fa-graduation-cap absolute right-2 top-3 text-white/50 text-xs"></i>
                        </div>
                    </div>

                    {{-- Email + WhatsApp --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                autocomplete="email" placeholder="Email address"
                                class="{{ ($errors->has('email')) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                            <i class="fa-regular fa-envelope absolute right-2 top-3 text-white/50 text-xs"></i>
                        </div>
                        <div class="relative">
                            <input type="tel" id="wa" name="wa" value="{{ old('wa') }}" required maxlength="20"
                                autocomplete="tel" placeholder="WhatsApp (08xxxxxxxxxx)"
                                class="{{ ($errors->has('wa')) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                            <i class="fa-brands fa-whatsapp absolute right-2 top-3 text-white/50 text-xs"></i>
                        </div>
                    </div>

                    {{-- Password + Konfirmasi --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">
                        <div class="relative">
                            <input type="password" id="password" name="password" required minlength="8"
                                autocomplete="new-password" placeholder="Password (min. 8 karakter)"
                                class="{{ ($errors->has('password')) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                            <i id="eye-password"
                                class="fa-solid fa-eye absolute right-2 top-3 text-white/50 text-xs cursor-pointer"
                                onclick="togglePassword('password', 'eye-password')"></i>
                        </div>
                        <div class="relative">
                            <input type="password" id="konfirmasi_password" name="konfirmasi_password" required
                                autocomplete="new-password" placeholder="Konfirmasi password"
                                class="{{ ($errors->has('konfirmasi_password') || $mismatch) ? 'field-error' : '' }} minimal-input w-full py-2 pr-8 text-sm">
                            <i id="eye-confirm"
                                class="fa-solid fa-eye absolute right-2 top-3 text-white/50 text-xs cursor-pointer"
                                onclick="togglePassword('konfirmasi_password', 'eye-confirm')"></i>
                        </div>
                    </div>

                    {{-- tempat pesan error tinggi maks. 2 baris, di ruang kosong antara kolom dan tombol --}}
                    <div class="h-[50px]">
                        @if ($errors->any())
                        <div id="server-error" class="flex items-start gap-1.5 rounded-lg bg-[#F45D69]/20 border border-[#F45D69]/40 px-3 py-2 text-xs leading-4 text-white">
                            <i class="fa-solid fa-circle-exclamation text-[#F45D69] mt-0.5 shrink-0"></i>
                            <span class="line-clamp-2">{{ $errors->first() }}</span>
                        </div>
                        @endif

                        <div id="client-error" style="display:none" class="flex items-start gap-1.5 rounded-lg bg-[#F45D69]/20 border border-[#F45D69]/40 px-3 py-2 text-xs leading-4 text-white">
                            <i class="fa-solid fa-circle-exclamation text-[#F45D69] mt-0.5 shrink-0"></i>
                            <span id="client-error-text" class="line-clamp-2"></span>
                        </div>
                    </div>

                    <div class="mt-auto pt-3">
                        <button type="submit"
                            class="w-full py-3 px-6 rounded-full bg-white text-[#162945] font-bold text-xs uppercase tracking-widest shadow-lg hover:bg-[#F45D69] hover:text-white hover:shadow-[#F45D69]/30 transition duration-300">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-4 text-center text-xs text-white/60">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-[#39D9C1] hover:underline ml-1">
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

        // menampilkan kolom sesuai jenis akun
        const tipeSelect = document.getElementById('tipe');
        const namaInput = document.getElementById('nama');
        const mhsFields = document.getElementById('mhs-fields');
        const npmInput = document.getElementById('npm');
        const prodiInput = document.getElementById('program_studi');

        function updateFields() {
            const isMahasiswa = tipeSelect.value === 'mahasiswa';
            const isOrganisasi = tipeSelect.value === 'organisasi';

            // input yang disabled tidak ikut terkirim ke server.
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

        // cek password sama / tidak
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

        // cek langsung saat mengetik: pesan memakai slot error yang sama
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

        // validasi instan (tanpa menunggu server)
        const registerForm = document.getElementById('register-form');
        const clientError = document.getElementById('client-error');
        const clientErrorText = document.getElementById('client-error-text');

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

        // Garis merah hilang begitu kolomnya diperbaiki
        registerForm.addEventListener('input', e => {
            // Kolom konfirmasi diatur oleh checkPassword() selama pesan "belum sama" tampil
            if (e.target === confirmInput && mismatchShown) return;
            e.target.classList.remove('field-error');
        });
        registerForm.addEventListener('change', e => e.target.classList.remove('field-error'));

        registerForm.addEventListener('submit', function (e) {
            const error = firstError();
            if (!error) return; // lolos: kirim ke server (server tetap memvalidasi ulang)

            e.preventDefault();
            mismatchShown = false;
            showClientError(error[0], error[1]);
            error[1].focus();
        });
    </script>

</body>

</html>