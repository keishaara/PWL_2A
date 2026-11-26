@auth
<div id="logout-confirm-modal" style="display: none;"
     class="fixed inset-0 z-[100] items-center justify-center p-4 bg-[#14213D]/60 backdrop-blur-sm"
     role="dialog" aria-modal="true" aria-labelledby="logout-confirm-title">
    <div class="w-full max-w-sm rounded-2xl bg-white border border-slate-200 p-6 shadow-xl">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-9 h-9 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <h3 id="logout-confirm-title" class="text-base font-bold text-[#14213D]">Keluar dari akun?</h3>
        </div>
        <p class="text-xs text-slate-600 leading-relaxed">Anda harus masuk lagi untuk mengakses akun ini.</p>
        <div class="flex justify-end gap-2 mt-5">
            <button type="button" id="logout-confirm-cancel"
                    class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 font-semibold text-xs transition">Batal</button>
            <button type="button" id="logout-confirm-ok"
                    class="px-4 py-2 rounded-xl bg-[#FF6B5B] hover:bg-[#e85a4a] text-white font-semibold text-xs transition shadow-sm">Ya, Keluar</button>
        </div>
    </div>
</div>

<script>
    (function () {
        const modal  = document.getElementById('logout-confirm-modal');
        const okBtn  = document.getElementById('logout-confirm-ok');
        const noBtn  = document.getElementById('logout-confirm-cancel');
        let pendingForm = null;

        function buka(form) { pendingForm = form; modal.style.display = 'flex'; noBtn.focus(); }
        function tutup()    { pendingForm = null; modal.style.display = 'none'; }

        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form && form.matches && form.matches('form[data-confirm-logout]')) {
                e.preventDefault();
                buka(form);
            }
        });

        okBtn.addEventListener('click', function () { if (pendingForm) pendingForm.submit(); });
        noBtn.addEventListener('click', tutup);
        modal.addEventListener('click', function (e) { if (e.target === modal) tutup(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && pendingForm) tutup(); });
    })();
</script>
@endauth