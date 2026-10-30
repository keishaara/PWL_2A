<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Evently</title>

    @vite(['resources/css/app.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .auth-card {
            max-width: 600px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .auth-input {
            padding: 12px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            width: 100%;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .auth-input:focus {
            border-color: #2e4c82;
            box-shadow: 0 0 0 3px rgba(46, 76, 130, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .auth-input {
            padding-right: 44px;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f4f7f6] px-4 py-10">

    <main class="mx-auto w-full auth-card rounded-[20px] border border-[#edf2f7] bg-white p-6 sm:p-10">

        <div class="mb-8 text-center">
            <a href="/" class="text-2xl font-extrabold text-[#2e4c82]">
                <i class="fa-solid fa-calendar-days mr-2"></i>Evently
            </a>

            <h1 class="mt-5 text-2xl font-bold text-slate-800">
                Buat Akun Baru
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Daftar untuk mulai mengikuti berbagai acara menarik.
            </p>
        </div>

        @if (session('msg'))
            <div class="mb-5 rounded-lg bg-green-50 p-3 text-sm text-green-700">
                {{ session('msg') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-600">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="tipe" class="mb-2 block text-sm font-semibold text-slate-700">
                    Daftar Sebagai
                </label>

                <select id="tipe" name="tipe" class="auth-input bg-white" required>
                    <option value="">Pilih jenis akun</option>
                    <option value="mahasiswa" {{ old('tipe') == 'mahasiswa' ? 'selected' : '' }}>
                        Mahasiswa
                    </option>
                    <option value="organisasi" {{ old('tipe') == 'organisasi' ? 'selected' : '' }}>
                        Organisasi
                    </option>
                </select>
            </div>

            <div>
                <label for="nama" class="mb-2 block text-sm font-semibold text-slate-700">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    class="auth-input"
                    placeholder="Masukkan nama lengkap"
                    autocomplete="name"
                    required
                >
            </div>

            <div id="npm-wrapper">
                <label for="npm" class="mb-2 block text-sm font-semibold text-slate-700">
                    NPM
                </label>

                <input
                    type="text"
                    id="npm"
                    name="npm"
                    value="{{ old('npm') }}"
                    class="auth-input"
                    placeholder="Masukkan NPM"
                >
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="auth-input"
                    placeholder="nama@email.com"
                    autocomplete="email"
                    required
                >
            </div>

            <div>
                <label for="program_studi" class="mb-2 block text-sm font-semibold text-slate-700">
                    Program Studi
                </label>

                <input
                    type="text"
                    id="program_studi"
                    name="program_studi"
                    value="{{ old('program_studi') }}"
                    class="auth-input"
                    placeholder="Masukkan program studi"
                    required
                >
            </div>

            <div>
                <label for="wa" class="mb-2 block text-sm font-semibold text-slate-700">
                    Nomor WhatsApp
                </label>

                <input
                    type="tel"
                    id="wa"
                    name="wa"
                    value="{{ old('wa') }}"
                    class="auth-input"
                    placeholder="Contoh: 081234567890"
                    autocomplete="tel"
                    required
                >
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                    Password
                </label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="auth-input"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password', 'eye-password')"
                        aria-label="Tampilkan password"
                    >
                        <i id="eye-password" class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <label for="konfirmasi_password" class="mb-2 block text-sm font-semibold text-slate-700">
                    Konfirmasi Password
                </label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="konfirmasi_password"
                        name="konfirmasi_password"
                        class="auth-input"
                        placeholder="Masukkan ulang password"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('konfirmasi_password', 'eye-confirm')"
                        aria-label="Tampilkan konfirmasi password"
                    >
                        <i id="eye-confirm" class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <p id="password-message" class="mt-2 hidden text-xs text-red-500">
                    Password dan konfirmasi password tidak sama.
                </p>
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-[#2e4c82] px-4 py-3 font-semibold text-white transition hover:bg-[#1e3a5f] focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                Daftar Sekarang
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-[#2e4c82] hover:underline">
                Masuk di sini
            </a>
        </p>

    </main>

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
        const npmWrapper = document.getElementById('npm-wrapper');
        const npmInput = document.getElementById('npm');

        function updateNpmField() {
            const isMahasiswa = tipeSelect.value === 'mahasiswa';

            npmWrapper.style.display = isMahasiswa ? 'block' : 'none';
            npmInput.required = isMahasiswa;

            if (!isMahasiswa) {
                npmInput.value = '';
            }
        }

        tipeSelect.addEventListener('change', updateNpmField);
        updateNpmField();

        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('konfirmasi_password');
        const passwordMessage = document.getElementById('password-message');

        function checkPassword() {
            const passwordsMatch =
                confirmInput.value === '' ||
                passwordInput.value === confirmInput.value;

            passwordMessage.classList.toggle(
                'hidden',
                passwordsMatch
            );

            confirmInput.setCustomValidity(
                passwordsMatch ? '' : 'Password tidak sama.'
            );
        }

        passwordInput.addEventListener('input', checkPassword);
        confirmInput.addEventListener('input', checkPassword);
    </script>

</body>
</html>
