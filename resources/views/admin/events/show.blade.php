
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Acara - Admin Univents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#162945',
                            coral: '#F45D69',
                            cyan: '#39D9C1',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    @include('admin.partials.header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('admin.partials.sidebar', ['active' => 'verification'])

        <main class="flex-1 min-w-0">

            <div class="mb-6">
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-brand-coral mb-4">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>

                <h1 class="text-2xl font-extrabold text-brand-navy">Detail Acara</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Informasi lengkap acara yang diajukan oleh organisasi.
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Banner acara --}}
                @if($event->banner)
                    <img src="{{ $event->banner_url }}"
                         alt="Banner {{ $event->title }}"
                         class="w-full h-56 sm:h-72 object-cover">
                @else
                    <div class="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-400">
                        <i class="fa-regular fa-image text-5xl"></i>
                    </div>
                @endif

                <div class="p-5 sm:p-7">

                    {{-- Judul dan status --}}
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                        <div>
                            <span class="text-xs font-bold text-brand-coral uppercase tracking-wider">
                                {{ $event->category->name ?? 'Tanpa Kategori' }}
                            </span>

                            <h2 class="text-xl sm:text-2xl font-extrabold text-brand-navy mt-2">
                                {{ $event->title }}
                            </h2>

                            <p class="text-xs text-slate-500 mt-2">
                                <i class="fa-solid fa-building mr-1"></i>
                                {{ $event->organization->name ?? 'Organisasi tidak tersedia' }}
                            </p>
                        </div>

                        <div class="shrink-0">
                            @if($event->status === 'approved')
                                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <i class="fa-solid fa-circle-check"></i> Disetujui
                                </span>
                            @elseif($event->status === 'rejected')
                                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                    <i class="fa-solid fa-hourglass-half"></i> Perlu Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="border-slate-100 mb-6">

                    {{-- Informasi acara --}}
                    <h3 class="text-sm font-extrabold text-brand-navy mb-4">
                        Informasi Acara
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-7">

                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-semibold">Lokasi</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">
                                    {{ $event->location ?: '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-semibold">Mulai</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">
                                    {{ $event->start_date?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-semibold">Selesai</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">
                                    {{ $event->end_date?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-semibold">Kuota Peserta</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">
                                    {{ $event->quota }} peserta
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-semibold">Biaya Pendaftaran</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">
                                    @if((float) $event->price > 0)
                                        Rp {{ number_format($event->price, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </p>
                            </div>
                        </div>

                    </div>

                    {{-- Deskripsi --}}
                    <div class="border-t border-slate-100 pt-6 mb-7">
                        <h3 class="text-sm font-extrabold text-brand-navy mb-3">
                            Deskripsi Acara
                        </h3>

                        <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                            {{ $event->description ?: 'Tidak ada deskripsi acara.' }}
                        </div>
                    </div>

                    {{-- Informasi pembayaran --}}
                    @if((float) $event->price > 0)
                        <div class="border-t border-slate-100 pt-6 mb-7">
                            <h3 class="text-sm font-extrabold text-brand-navy mb-4">
                                Informasi Pembayaran
                            </h3>

                            <div class="bg-slate-50 rounded-xl p-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[11px] text-slate-400 font-semibold">Bank</p>
                                    <p class="text-sm font-semibold text-slate-700 mt-1">
                                        {{ $event->bank_name ?: '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-[11px] text-slate-400 font-semibold">Nomor Rekening</p>
                                    <p class="text-sm font-semibold text-slate-700 mt-1">
                                        {{ $event->bank_account_number ?: '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-[11px] text-slate-400 font-semibold">Atas Nama</p>
                                    <p class="text-sm font-semibold text-slate-700 mt-1">
                                        {{ $event->bank_account_holder ?: '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Alasan penolakan --}}
                    @if($event->status === 'rejected' && $event->rejection_reason)
                        <div class="border border-rose-200 bg-rose-50 rounded-xl p-4 mb-7">
                            <p class="text-xs font-bold text-rose-700 mb-2">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                Alasan Penolakan
                            </p>
                            <p class="text-sm text-rose-600">
                                {{ $event->rejection_reason }}
                            </p>
                        </div>
                    @endif

                    {{-- Aksi admin --}}
                    @if($event->status === 'pending')
                        <div class="border-t border-slate-100 pt-6 flex flex-wrap gap-3">

                            <form action="{{ route('admin.events.approve', $event->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menyetujui acara ini?')">
                                @csrf
                                <button type="submit"
                                        class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                    <i class="fa-solid fa-check mr-1"></i>
                                    Setujui Acara
                                </button>
                            </form>

                            <button type="button"
                                    onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                                    class="px-5 py-2.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold transition">
                                <i class="fa-solid fa-xmark mr-1"></i>
                                Tolak Acara
                            </button>

                        </div>
                    @endif

                </div>
            </div>

        </main>
    </div>

    {{-- Modal penolakan --}}
    @if($event->status === 'pending')
    <div id="rejectModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
            <h3 class="text-base font-extrabold text-brand-navy mb-4">
                Tolak Pengajuan Acara
            </h3>

            <form action="{{ route('admin.events.reject', $event->id) }}" method="POST">
                @csrf

                <label class="block text-xs font-bold text-slate-700 mb-2">
                    Alasan Penolakan
                </label>

                <textarea name="rejection_reason" rows="4" required minlength="5" maxlength="500"
                          placeholder="Tuliskan alasan penolakan..."
                          class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400"></textarea>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button"
                            onclick="document.getElementById('rejectModal').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                        Batal
                    </button>

                    <button type="submit"
                            class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-500 hover:bg-rose-600 text-white">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @include('admin.partials.footer')
</body>
</html>
