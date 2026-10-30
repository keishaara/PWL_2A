<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Univents</title>

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

        .minimal-input::placeholder {
            color: rgba(255, 255, 255, 0.45);
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
    </style>
</head>

<body class="page-bg min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[540px]">
        <div class="relative w-full md:w-1/2 min-h-[260px] md:min-h-full flex flex-col justify-between p-8 sm:p-10 text-white overflow-hidden">
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

        <div class="w-full md:w-1/2 bg-[#162945] p-8 sm:p-12 flex flex-col justify-between text-white">

            <div class="text-center pt-2">
                <div class="brand-bracket">
                    <span class="text-base sm:text-lg font-bold tracking-[0.25em] text-white">
                        UNIVENTS
                    </span>
                </div>
            </div>

            <div class="my-auto py-6">

                @if ($errors->any())
                <div class="mb-5 rounded-lg bg-[#F45D69]/20 border border-[#F45D69]/40 p-3 text-xs text-white">
                    <i class="fa-solid fa-circle-exclamation text-[#F45D69] mr-1"></i>
                    {{ $errors->first() }}
                </div>
                @endif

                @if (session('success'))
                <div class="mb-5 rounded-lg bg-[#39D9C1]/20 border border-[#39D9C1]/40 p-3 text-xs text-white">
                    <i class="fa-solid fa-circle-check text-[#39D9C1] mr-1"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="relative">
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Email address"
                            class="minimal-input w-full py-2.5 pr-8 text-sm">
                        <i class="fa-regular fa-envelope absolute right-2 top-3 text-white/50 text-xs"></i>
                    </div>

                    <div class="relative">
                        <select
                            name="role"
                            required
                            class="minimal-input w-full py-2.5 pr-8 text-sm appearance-none cursor-pointer">
                            <option value="" disabled selected class="bg-[#162945] text-white/50">Pilih peran akun</option>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }} class="bg-[#162945] text-white">Mahasiswa</option>
                            <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }} class="bg-[#162945] text-white">Penyelenggara</option>
                        </select>

                        <i class="fa-solid fa-chevron-down absolute right-2 top-3.5 text-white/50 text-xs pointer-events-none"></i>
                    </div>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="Password"
                            class="minimal-input w-full py-2.5 pr-8 text-sm">
                        <i
                            id="togglePasswordIcon"
                            class="fa-solid fa-eye absolute right-2 top-3 text-white/50 text-xs cursor-pointer"
                            onclick="togglePassword('password', 'togglePasswordIcon')"></i>
                    </div>

                    <div class="flex items-center justify-between text-xs text-white/70 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none hover:text-white transition">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-white/20 bg-transparent text-[#F45D69] focus:ring-0 h-3.5 w-3.5">
                            <span>Ingat saya</span>
                        </label>
                        <a href="#" onclick="alert('Fitur reset password via email akan segera hadir!')" class="text-[#39D9C1] hover:underline transition">
                            Lupa password?
                        </a>
                    </div>

                    <div class="pt-3">
                        <button
                            type="submit"
                            class="w-full py-3 px-6 rounded-full bg-white text-[#162945] font-bold text-xs uppercase tracking-widest shadow-lg hover:bg-[#F45D69] hover:text-white hover:shadow-[#F45D69]/30 transition duration-300">
                            Masuk
                        </button>
                    </div>
                </form>

            </div>

            <div class="text-center text-xs text-white/60 pb-2">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-[#39D9C1] hover:underline ml-1">
                    Daftar di sini
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
    </script>

</body>

</html>