<div id="toast-bookmark"
     class="fixed top-20 right-4 z-50 w-[calc(100%-2rem)] sm:w-96 transition duration-300 ease-out {{ session('bookmark') ? '' : 'opacity-0' }}"
     style="{{ session('bookmark') ? '' : 'display: none;' }}">
    <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-brand-amber shadow-lg">
        <div class="w-8 h-8 rounded-full bg-brand-amber/30 text-[#8F6800] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-bookmark text-sm"></i>
        </div>
        <div class="flex-1 text-xs sm:text-sm text-brand-navy leading-snug">
            <span id="toast-bookmark-text">{{ session('bookmark') }}</span>
            <a href="{{ route('bookmarks.index') }}" class="block mt-1 font-bold text-brand-coral hover:underline">Lihat Tersimpan</a>
        </div>
        <button type="button" onclick="closeToast()" class="text-slate-400 hover:text-brand-navy" aria-label="Tutup">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>

<script>
    (function () {
        const toast = document.getElementById('toast-bookmark');
        const text  = document.getElementById('toast-bookmark-text');
        let hideTimer, removeTimer;

        window.closeToast = function () {
            toast.classList.add('opacity-0');
            removeTimer = setTimeout(function () { toast.style.display = 'none'; }, 300);
        };

        window.showToast = function (message) {
            clearTimeout(hideTimer);
            clearTimeout(removeTimer);
            text.textContent = message;
            toast.style.display = '';
            void toast.offsetWidth;
            toast.classList.remove('opacity-0');
            hideTimer = setTimeout(window.closeToast, 3000);
        };

        @if (session('bookmark'))
        hideTimer = setTimeout(window.closeToast, 3000);
        @endif

        const GAYA = {
            card:   { on: ['text-brand-coral'],
                      off: ['text-slate-400', 'hover:text-brand-coral'] },
            detail: { on: ['bg-brand-coral/10', 'border-brand-coral', 'text-brand-coral'],
                      off: ['border-slate-300', 'text-slate-600', 'hover:border-brand-navy', 'hover:text-brand-navy'] }
        };

        function terapkan(btn, tersimpan) {
            const gaya  = GAYA[btn.dataset.variant];
            const icon  = btn.querySelector('i');
            const label = btn.querySelector('[data-bookmark-label]');

            if (gaya) {
                btn.classList.remove.apply(btn.classList, tersimpan ? gaya.off : gaya.on);
                btn.classList.add.apply(btn.classList, tersimpan ? gaya.on : gaya.off);
            }
            if (icon) {
                icon.classList.remove(tersimpan ? 'fa-regular' : 'fa-solid');
                icon.classList.add(tersimpan ? 'fa-solid' : 'fa-regular');
            }
            if (label) label.textContent = tersimpan ? 'Tersimpan' : 'Simpan Acara';
            if (btn.dataset.variant === 'card') {
                btn.title = tersimpan ? 'Hapus dari tersimpan' : 'Simpan acara';
            }
        }

        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form.matches || !form.matches('form[data-bookmark-form]')) return;

            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            if (btn.disabled) return;
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (res) {
                if (res.status === 401 || res.status === 419) {
                    window.location.href = @json(route('login'));
                    return null;
                }
                if (!res.ok) throw new Error('gagal');
                return res.json();
            })
            .then(function (data) {
                if (!data) return;
                terapkan(btn, data.bookmarked);
                window.showToast(data.message);
            })
            .catch(function () { form.submit(); })
            .finally(function () { btn.disabled = false; });
        });
    })();
</script>