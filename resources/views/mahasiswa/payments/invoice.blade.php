<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $payment->invoice_number }} - Univents</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#162945',
                            coral: '#F45D69',
                            cyan: '#39D9C1',
                            amber: '#FCCC6B',
                            bg: '#F8FAFC'
                        }
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
    </style>
</head>
<body class="bg-brand-bg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain bg-white rounded-md p-1">
                    <span class="text-xl font-extrabold tracking-tight text-white hidden sm:inline">Uni<span class="text-brand-cyan">vents</span></span>
                </a>

                <div class="hidden sm:block h-5 w-[1px] bg-white/20"></div>

                <nav class="hidden sm:flex items-center gap-4 text-xs font-semibold text-white/80">
                    <a href="{{ route('dashboard') }}" class="hover:text-brand-cyan transition">Dashboard</a>
                    <a href="{{ route('events.index') }}" class="hover:text-brand-cyan transition">Jelajah Acara</a>
                    <a href="{{ route('payments.index') }}" class="text-brand-cyan transition">Status Pembayaran</a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-xs font-semibold text-white/80">
                    {{ Auth::user()->name }}
                </span>
                <a href="{{ route('payments.index') }}" class="text-xs font-medium bg-white/10 text-white px-3 py-1.5 rounded-lg hover:bg-white/20 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-receipt text-brand-cyan"></i>
                    <span>Tagihan Saya</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('events.index') }}" class="hover:text-brand-navy">Acara</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <a href="{{ route('payments.index') }}" class="hover:text-brand-navy">Pembayaran</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-brand-navy font-semibold">Checkout Invoice</span>
            </div>

            <a href="{{ route('payments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-brand-coral transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Riwayat Pembayaran</span>
            </a>
        </div>

        @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if (session('info'))
        <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs sm:text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
            <div>{{ session('info') }}</div>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm">
            <div class="font-bold mb-1 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Gagal Mengunggah:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-7 relative overflow-hidden">
                    <div class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-r from-brand-navy via-brand-cyan to-brand-coral"></div>

                    <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Invoice Tagihan Acara
                            </span>
                            <h1 class="text-xl sm:text-2xl font-extrabold text-brand-navy mt-1">
                                {{ $payment->invoice_number }}
                            </h1>
                            <p class="text-xs text-slate-500 mt-1">
                                Diterbitkan pada: {{ $payment->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                        </div>

                        <div>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full border {{ $payment->status_badge_class }}">
                                @if($payment->status === 'paid')
                                    <i class="fa-solid fa-circle-check"></i>
                                @elseif($payment->status === 'waiting_verification')
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                @elseif($payment->status === 'rejected')
                                    <i class="fa-solid fa-circle-xmark"></i>
                                @else
                                    <i class="fa-solid fa-hourglass-half"></i>
                                @endif
                                <span>{{ $payment->status_label }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="py-5 border-b border-slate-100 flex items-start gap-4">
                        @if($payment->event->banner)
                            <img src="{{ asset('storage/' . $payment->event->banner) }}" alt="{{ $payment->event->title }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover border border-slate-100 flex-shrink-0">
                        @else
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 flex-shrink-0">
                                <i class="fa-regular fa-image text-2xl"></i>
                            </div>
                        @endif

                        <div class="flex-1">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-brand-navy/5 text-brand-navy uppercase tracking-wider">
                                {{ $payment->event->category->name ?? 'Kegiatan Kampus' }}
                            </span>
                            <h3 class="text-sm sm:text-base font-bold text-brand-navy mt-1 line-clamp-2">
                                {{ $payment->event->title }}
                            </h3>
                            <div class="flex flex-wrap items-center gap-3 text-[11px] text-slate-500 mt-1.5">
                                <span><i class="fa-regular fa-calendar text-slate-400 mr-1"></i> {{ $payment->event->start_date->translatedFormat('d M Y') }}</span>
                                <span><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> {{ $payment->event->location }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="py-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs border-b border-slate-100">
                        <div>
                            <span class="text-slate-400 block mb-1">Ditagihkan Kepada:</span>
                            <p class="font-bold text-brand-navy">{{ $payment->user->name }}</p>
                            <p class="text-slate-500 text-[11px]">{{ $payment->user->npm ?? 'Mahasiswa' }} &bull; {{ $payment->user->email }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-1">Batas Waktu Pembayaran:</span>
                            <p class="font-bold text-rose-600 flex items-center gap-1.5">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $payment->expires_at ? $payment->expires_at->translatedFormat('d F Y, H:i') . ' WIB' : '24 Jam setelah checkout' }}</span>
                            </p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Segera transfer sebelum batas waktu berakhir</p>
                        </div>
                    </div>

                    <div class="pt-5 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 font-medium block">Total Pembayaran:</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-brand-navy">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="button" onclick="window.print()" class="px-3 py-2 text-xs font-semibold text-slate-600 hover:text-brand-navy bg-slate-100 hover:bg-slate-200 rounded-lg transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-print"></i>
                            <span class="hidden sm:inline">Cetak Invoice</span>
                        </button>
                    </div>

                    @if($payment->rejection_reason)
                    <div class="mt-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800">
                        <div class="font-bold mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                            <span>Alasan Pembayaran Ditolak:</span>
                        </div>
                        <p class="text-rose-700 leading-relaxed">{{ $payment->rejection_reason }}</p>
                        <p class="mt-2 text-[11px] text-rose-500">Silakan unggah ulang foto bukti transfer yang jelas dan sesuai.</p>
                    </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-7">
                    <h3 class="text-sm font-bold text-brand-navy flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-building-columns text-brand-coral"></i>
                        <span>Rekening Tujuan Pembayaran</span>
                    </h3>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Nama Bank</span>
                            <span class="text-xs font-bold text-brand-navy uppercase">{{ $payment->bank_name ?? 'Bank Mandiri' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Nomor Rekening</span>
                            <div class="flex items-center gap-2">
                                <span id="accNumber" class="text-sm font-mono font-bold text-brand-coral tracking-wider">
                                    {{ $payment->bank_account_number ?? '123-00-9876543-2' }}
                                </span>
                                <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('accNumber').innerText); alert('Nomor rekening berhasil disalin!')" class="p-1 px-2 text-[10px] font-bold bg-white border border-slate-200 rounded text-slate-600 hover:text-brand-navy transition">
                                    <i class="fa-regular fa-copy"></i> Salin
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Atas Nama (A/N)</span>
                            <span class="text-xs font-bold text-brand-navy">{{ $payment->bank_account_holder ?? 'Panitia Acara Kampus' }}</span>
                        </div>
                    </div>

                    <div class="mt-5 space-y-2.5 text-xs text-slate-600">
                        <p class="font-bold text-slate-800">Langkah-langkah:</p>
                        <ol class="list-decimal list-inside space-y-1.5 text-slate-500">
                            <li>Transfer tepat sejumlah <span class="font-bold text-brand-navy">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span> ke rekening di atas melalui ATM, M-Banking, atau Internet Banking.</li>
                            <li>Simpan atau tangkap layar (screenshot) struk bukti transaksi pembayaran Anda.</li>
                            <li>Unggah file foto bukti tersebut pada form di samping sebelum batas waktu habis.</li>
                            <li>Tunggu panitia memeriksa dan memverifikasi bukti pembayaran Anda.</li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-5 space-y-6">

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-7 sticky top-24">
                    <h3 class="text-base font-extrabold text-brand-navy flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-cloud-arrow-up text-brand-cyan"></i>
                        <span>Upload Bukti Transfer</span>
                    </h3>
                    <p class="text-xs text-slate-500 mb-6">
                        Pastikan bukti transfer mencantumkan nomor transaksi, tanggal, dan nominal yang jelas.
                    </p>

                    @if ($payment->status === 'paid')
                        <div class="text-center py-8 px-4 rounded-xl bg-emerald-50 border border-emerald-200">
                            <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 text-2xl mx-auto mb-3">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <h4 class="text-sm font-bold text-emerald-900">Pembayaran Telah Lunas</h4>
                            <p class="text-xs text-emerald-700 mt-1">
                                Pembayaran untuk acara ini telah berhasil diverifikasi oleh panitia.
                            </p>

                            @if($payment->payment_proof)
                            <div class="mt-4 pt-4 border-t border-emerald-200/60 text-left">
                                <span class="text-[11px] font-semibold text-emerald-800 block mb-2">Foto Bukti Anda:</span>
                                <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="block group relative rounded-lg overflow-hidden border border-emerald-300">
                                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Transfer" class="w-full h-36 object-cover group-hover:opacity-90 transition">
                                    <span class="absolute inset-0 bg-black/40 flex items-center justify-center text-white text-xs font-semibold opacity-0 group-hover:opacity-100 transition">
                                        <i class="fa-solid fa-magnifying-glass-plus mr-1"></i> Lihat Gambar Penuh
                                    </span>
                                </a>
                            </div>
                            @endif

                            <div class="mt-6">
                                <a href="{{ route('payments.index') }}" class="w-full py-3 px-4 rounded-xl bg-brand-navy text-white text-xs font-bold hover:bg-slate-800 transition inline-block">
                                    Lihat Riwayat & Tiket
                                </a>
                            </div>
                        </div>

                    @else

                        @if($payment->status === 'waiting_verification' && $payment->payment_proof)
                        <div class="mb-5 p-4 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-800">
                            <div class="font-bold flex items-center gap-1.5 mb-2">
                                <i class="fa-solid fa-hourglass-start text-blue-600"></i>
                                <span>Sedang Menunggu Verifikasi</span>
                            </div>
                            <p class="text-blue-700 mb-3">
                                Anda telah mengunggah bukti pembayaran. Pihak panitia sedang meninjau transfer Anda. Anda tetap dapat mengunggah bukti baru jika bukti sebelumnya salah atau buram.
                            </p>
                            <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-[11px] font-bold text-blue-800 underline hover:text-blue-900 flex items-center gap-1">
                                <i class="fa-regular fa-image"></i>
                                <span>Lihat bukti yang saat ini diunggah</span>
                            </a>
                        </div>
                        @endif

                        <form action="{{ route('payments.proof.store', $payment->invoice_number) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">
                                    Pilih Foto Struk / Bukti Transfer <span class="text-rose-500">*</span>
                                </label>

                                <div class="relative border-2 border-dashed border-slate-300 hover:border-brand-coral rounded-2xl p-6 text-center cursor-pointer transition bg-slate-50/50 hover:bg-slate-50 group">
                                    <input type="file" name="payment_proof" id="payment_proof" accept="image/png, image/jpeg, image/jpg" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(this)">
                                    
                                    <div id="uploadPlaceholder">
                                        <div class="w-12 h-12 rounded-full bg-brand-coral/10 text-brand-coral flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition">
                                            <i class="fa-solid fa-image text-xl"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-700">Klik atau geser file ke sini</p>
                                        <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, atau JPEG (Maks. 3 MB)</p>
                                    </div>

                                    <div id="imagePreviewContainer" class="hidden">
                                        <img id="imagePreview" src="#" alt="Preview" class="max-h-48 mx-auto rounded-lg shadow-sm border border-slate-200 object-cover mb-2">
                                        <p id="fileName" class="text-xs font-semibold text-brand-navy truncate max-w-xs mx-auto"></p>
                                        <span class="text-[11px] text-brand-coral font-bold mt-1 inline-block">Klik untuk mengganti foto</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="notes" class="block text-xs font-bold text-slate-700 mb-1">
                                    Catatan / Nama Pengirim (Opsional)
                                </label>
                                <textarea name="notes" id="notes" rows="2" placeholder="Contoh: Transfer dari rekening BNI a.n Budi Santoso" class="w-full text-xs rounded-xl border-slate-200 focus:border-brand-cyan focus:ring-brand-cyan/20 p-3">{{ old('notes', $payment->notes) }}</textarea>
                            </div>

                            <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-brand-coral text-white font-bold text-xs sm:text-sm hover:bg-[#e04d59] transition shadow-lg shadow-brand-coral/30 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>{{ $payment->payment_proof ? 'Kirim Ulang Bukti Pembayaran' : 'Kirim Bukti Pembayaran' }}</span>
                            </button>

                            <p class="text-[11px] text-center text-slate-400">
                                <i class="fa-solid fa-shield-halved mr-1"></i> Data dan bukti pembayaran Anda terlindungi dengan aman.
                            </p>
                        </form>
                    @endif

                </div>

            </div>

        </div>

    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Univents Kampus &bull; Platform Manajemen & Pendaftaran Acara Mahasiswa
    </footer>

    <script>
        function previewImage(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    fileName.textContent = file.name;
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>