<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Univents</title>

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
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            font-size: 0.875rem;
            background-color: #FDFCFA;
            border: 1.5px solid #CBD5E1;
            border-radius: 0.875rem;
            color: #14213D;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:hover {
            border-color: #94A3B8;
        }

        .form-input:focus {
            background-color: #FFFFFF;
            border-color: #1E90FF;
            box-shadow: 0 0 0 3px rgba(30, 144, 255, 0.18);
        }

        .form-input::placeholder {
            color: #64748B;
        }

        .form-input.field-error {
            border-color: #FF6B5B;
            background-color: #FFF5F5;
        }

        .relative > i {
            color: #64748B;
        }

        input[type="checkbox"] {
            accent-color: #1E90FF;
            width: 1rem;
            height: 1rem;
            cursor: pointer;
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

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden flex flex-col md:flex-row md:h-[560px]">

        <div class="photo-panel relative w-full md:w-1/2 min-h-[260px] md:min-h-full flex flex-col justify-between p-8 sm:p-10 text-white overflow-hidden bg-[#121E38]">

            <img src="https://images.unsplash.com/photo-1781038507661-06501ddcdc90?q=80&w=1373&auto=format&fit=crop"
                class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-100" alt="Kampus 1">

            <img src="https://i.pinimg.com/736x/ba/82/6d/ba826dafa21437cd34359d6df851af2b.jpg"
                referrerpolicy="no-referrer"
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

        <div class="w-full md:w-1/2 bg-white p-8 sm:p-12 flex flex-col justify-between">

            @php
                $timeoutMsg = session('session_timeout');
            @endphp

            <div class="flex flex-col items-center justify-center pt-2 pb-2 text-center">
                <a href="{{ url('/') }}" class="inline-block transition hover:opacity-90">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-11 sm:h-12 w-auto object-contain">
                </a>
                <h2 class="mt-3 text-xl font-bold text-[#14213D] tracking-tight">Selamat Datang</h2>
                <p class="text-xs text-slate-500 mt-1">Masuk ke akun Univents Anda untuk melanjutkan</p>
            </div>

            <div class="my-auto py-4">

                @if ($errors->any())
                <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-600 flex items-start gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                @if (session('success'))
                <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-xs text-emerald-700 flex items-start gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-[#14213D] mb-1.5">Email</label>
                        <div class="relative">
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="nama@kampus.ac.id"
                                class="form-input">
                            <i class="fa-regular fa-envelope absolute right-3.5 top-3.5 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#14213D] mb-1.5">Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                placeholder="Masukkan password"
                                class="form-input">
                            <i
                                id="togglePasswordIcon"
                                class="fa-solid fa-eye absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600 text-xs cursor-pointer"
                                onclick="togglePassword('password', 'togglePasswordIcon')"></i>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-600 pt-1">
                        <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer select-none">
                            <input type="checkbox" name="remember">
                            Ingat saya
                        </label>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full py-3 px-6 rounded-xl bg-[#1E90FF] hover:bg-[#1877d2] text-white font-bold text-xs uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-[#1E90FF]/25 transition duration-200">
                            Masuk
                        </button>
                    </div>
                </form>

            </div>

            <div class="text-center text-xs text-slate-500 pt-2 pb-1">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-[#1E90FF] hover:underline ml-1">
                    Daftar di sini
                </a>
            </div>

        </div>

    </div>

    @if ($timeoutMsg)
    <div id="sessionTimeoutModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#14213D]/60 backdrop-blur-sm transition-opacity duration-200">
        <div class="relative w-full max-w-sm rounded-2xl bg-[#FFFFFF] border border-slate-200 p-6 text-left shadow-xl">
            <div class="flex items-start justify-between gap-3 mb-2">
                <h3 class="text-base font-bold text-[#14213D]">Sesi Berakhir</h3>
                <button type="button" onclick="closeSessionModal()" class="text-slate-400 hover:text-slate-600 transition -mt-0.5" aria-label="Tutup">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed mb-5">
                {{ $timeoutMsg }}
            </p>

            <div class="flex justify-end">
                <button type="button" onclick="closeSessionModal()" class="px-5 py-2 rounded-xl bg-[#1E90FF] hover:bg-[#1877d2] text-white font-semibold text-xs transition shadow-sm">
                    Mengerti
                </button>
            </div>
        </div>
    </div>
    @endif

    <script>
        function closeSessionModal() {
            const modal = document.getElementById('sessionTimeoutModal');
            if (modal) {
                modal.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => modal.remove(), 250);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('sessionTimeoutModal');
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeSessionModal();
                    }
                });
            }
        });

        window.addEventListener('pageshow', (e) => {
            if (e.persisted) closeSessionModal();
        });

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
        };

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
