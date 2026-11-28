@auth
<form id="idle-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="silent" value="1">
</form>

<style>
    #idle-warning-modal button {
        outline: none;
    }

    #idle-warning-modal button:focus-visible {
        box-shadow: 0 0 0 3px rgba(30, 144, 255, 0.35);
    }
</style>

<div id="idle-warning-modal" style="display: none;"
    class="fixed inset-0 z-[100] items-center justify-center p-4 bg-[#14213D]/60 backdrop-blur-sm"
    role="alertdialog" aria-modal="true" aria-labelledby="idle-title" aria-describedby="idle-desc">
    <div class="w-full max-w-sm rounded-2xl bg-white border border-slate-200 p-6 shadow-xl">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-clock"></i>
            </div>
            <h3 id="idle-title" class="text-base font-bold text-[#14213D]">Sesi Akan Berakhir</h3>
        </div>
        <p id="idle-desc" class="text-xs text-slate-600 leading-relaxed">
            Anda tidak aktif beberapa saat. Demi keamanan, Anda akan otomatis keluar dalam
            <span id="idle-countdown" class="font-bold text-[#FF6B5B]">30</span> detik.
        </p>
        <p id="idle-desc-expired" style="display: none;" class="text-xs text-slate-600 leading-relaxed">
            Sesi Anda telah berakhir karena terlalu lama tidak aktif. Silakan login ulang untuk melanjutkan.
        </p>
        <div class="flex justify-end gap-2 mt-5">
            <button type="button" id="idle-login-btn" style="display: none;"
                class="px-4 py-2 rounded-xl bg-[#1E90FF] hover:bg-[#1877d2] text-white font-semibold text-xs transition shadow-sm">
                Login Ulang
            </button>
            <button type="button" id="idle-logout-btn"
                class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 font-semibold text-xs transition">
                Keluar
            </button>
            <button type="button" id="idle-extend-btn"
                class="px-4 py-2 rounded-xl bg-[#1E90FF] hover:bg-[#1877d2] text-white font-semibold text-xs transition shadow-sm">
                Perpanjang Sesi
            </button>
        </div>
    </div>
</div>

<script>
    (function() {
        const BATAS_IDLE_MS = 600000 * 1000;
        const HITUNG_MUNDUR = 30 * 1000;

        const KEEP_ALIVE_URL = "{{ route('session.keep-alive') }}";
        const LOGOUT_URL = "{{ route('logout') }}";
        const LOGIN_URL = "{{ route('login') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const STORAGE_KEY = 'univents:lastActivity';

        const modal = document.getElementById('idle-warning-modal');
        const countdownEl = document.getElementById('idle-countdown');
        const extendBtn = document.getElementById('idle-extend-btn');
        const logoutBtn = document.getElementById('idle-logout-btn');
        const logoutForm = document.getElementById('idle-logout-form');
        const titleEl = document.getElementById('idle-title');
        const descEl = document.getElementById('idle-desc');
        const descExpEl = document.getElementById('idle-desc-expired');
        const loginBtn = document.getElementById('idle-login-btn');

        let lastActivity = Date.now();
        let lastStored = 0;
        let lastPing = Date.now();
        let warningOpen = false;
        let loggingOut = false;
        let expired = false;
        let logoutPromise = Promise.resolve();

        function simpanAktivitas() {
            const now = Date.now();
            if (now - lastStored < 1000) return;
            lastStored = now;
            try {
                localStorage.setItem(STORAGE_KEY, String(now));
            } catch (e) {}
        }

        function keepAlive() {
            lastPing = Date.now();
            return fetch(KEEP_ALIVE_URL, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        }

        function tampilkanPeringatan(sisaMs) {
            if (!warningOpen) {
                warningOpen = true;
                modal.style.display = 'flex';
                extendBtn.focus();
            }
            countdownEl.textContent = Math.max(0, Math.ceil(sisaMs / 1000));
        }

        // idle sudah lewat batas total: tetap tampilkan popup dulu, user yang klik "Login Ulang"
        function tampilkanKedaluwarsa() {
            if (expired) return;
            expired = true;
            warningOpen = true;
            titleEl.textContent = 'Sesi Berakhir';
            descEl.style.display = 'none';
            descExpEl.style.display = 'block';
            extendBtn.style.display = 'none';
            logoutBtn.style.display = 'none';
            loginBtn.style.display = 'inline-block';
            modal.style.display = 'flex';
            loginBtn.focus();

            // matikan sesi di server sekarang, supaya kalau halaman di-refresh tidak masuk dashboard lagi
            const body = new URLSearchParams();
            body.set('silent', '1');
            logoutPromise = fetch(LOGOUT_URL, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'text/html'
                },
                body: body
            }).catch(function() {});
        }

        function sembunyikanPeringatan() {
            warningOpen = false;
            modal.style.display = 'none';
        }

        function keluar() {
            if (loggingOut) return;
            loggingOut = true;
            logoutForm.submit();
        }

        function perpanjang() {
            extendBtn.disabled = true;
            keepAlive()
                .then(function(res) {
                    if (res.status === 401 || res.status === 419) {
                        tampilkanKedaluwarsa();
                        return;
                    }
                    lastActivity = Date.now();
                    simpanAktivitas();
                    sembunyikanPeringatan();
                })
                .catch(function() {
                    lastActivity = Date.now();
                    sembunyikanPeringatan();
                })
                .finally(function() {
                    extendBtn.disabled = false;
                });
        }

        function aktivitas() {
            if (warningOpen || loggingOut) return; // saat popup muncul, hanya tombol yang boleh memperpanjang
            lastActivity = Date.now();
            simpanAktivitas();
            if (Date.now() - lastPing > 5 * 60 * 1000) keepAlive().catch(function() {});
        }

        ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart'].forEach(function(nama) {
            window.addEventListener(nama, aktivitas, true);
        });

        window.addEventListener('storage', function(e) {
            if (expired) return;
            if (e.key === STORAGE_KEY && e.newValue) {
                lastActivity = Number(e.newValue) || Date.now();
            }
        });

        extendBtn.addEventListener('click', perpanjang);
        logoutBtn.addEventListener('click', keluar);
        loginBtn.addEventListener('click', function() {
            loggingOut = true;
            loginBtn.disabled = true;
            logoutPromise.then(function() {
                window.location.href = LOGIN_URL;
            });
        });

        function cek() {
            if (loggingOut || expired) return;
            const diam = Date.now() - lastActivity;

            if (diam >= BATAS_IDLE_MS + HITUNG_MUNDUR) {
                tampilkanKedaluwarsa();
            } else if (diam >= BATAS_IDLE_MS) {
                tampilkanPeringatan(BATAS_IDLE_MS + HITUNG_MUNDUR - diam);
            } else if (warningOpen) {
                sembunyikanPeringatan();
            }
        }

        setInterval(cek, 1000);
        // timer di tab background / laptop sleep ditunda browser, jadi cek langsung saat tab aktif lagi
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) cek();
        });
    })();
</script>
@endauth