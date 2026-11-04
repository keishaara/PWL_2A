@if (session('bookmark'))
    <div id="toast-bookmark"
         class="fixed top-20 right-4 z-50 w-[calc(100%-2rem)] sm:w-96 transition duration-300 ease-out">
        <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-brand-amber shadow-lg">
            <div class="w-8 h-8 rounded-full bg-brand-amber/30 text-[#8F6800] flex items-center justify-center shrink-0">
                <i class="fa-solid fa-bookmark text-sm"></i>
            </div>
            <div class="flex-1 text-xs sm:text-sm text-brand-navy leading-snug">
                {{ session('bookmark') }}
                <a href="{{ route('bookmarks.index') }}" class="block mt-1 font-bold text-brand-coral hover:underline">Lihat Tersimpan</a>
            </div>
            <button type="button" onclick="closeToast()" class="text-slate-400 hover:text-brand-navy" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <script>
        function closeToast() {
            const t = document.getElementById('toast-bookmark');
            if (!t) return;
            t.classList.add('opacity-0', '-translate-y-2');
            setTimeout(() => t.remove(), 300);
        }
        setTimeout(closeToast, 3000);
    </script>
@endif