<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Acara Baru - Univents</title>
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

<body class="bg-[#F8FAFC] text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain">
                <span class="text-xl font-extrabold tracking-tight text-white">Uni<span class="text-brand-cyan">vents</span></span>
                <span class="ml-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-400/20 text-blue-300 border border-blue-400/30 uppercase tracking-wider">Penyelenggara</span>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-xs font-semibold text-white/90">{{ Auth::user()->name }}</span>
                <a href="{{ route('organisasi.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-white/10 text-white hover:bg-white/20 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Dasbor</span>
                </a>
            </div>
        </div>
    </header>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">        
        @include('organisasi.partials.sidebar', ['active' => 'create_event'])
        <main class="flex-1 min-w-0">

            <div class="mb-8">
                <span class="text-xs font-bold text-brand-coral uppercase tracking-wider block mb-1">Manajemen Acara Kampus</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-navy">Publikasikan Acara Baru</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Isi formulir di bawah. Pratinjau tampilan di katalog mahasiswa akan langsung terlihat di panel kanan.</p>
            </div>

            @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                    <span>Mohon periksa kembali isian formulir:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-rose-700 ml-4">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('organisasi.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">

                    <div class="xl:col-span-7 space-y-6">

                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-5">
                            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-xl bg-brand-navy/5 text-brand-navy flex items-center justify-center font-bold text-sm">1</div>
                                <div>
                                    <h3 class="font-bold text-brand-navy text-sm">Informasi Utama Acara</h3>
                                    <p class="text-[11px] text-slate-400">Tentukan nama, kategori, dan deskripsi acara Anda.</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Acara <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" id="inputTitle" value="{{ old('title') }}" required
                                    placeholder="Contoh: Seminar Nasional AI & Quantum Computing 2026"
                                    oninput="updatePreviewTitle(this.value)"
                                    class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:ring-1 focus:ring-brand-navy focus:outline-none transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Acara <span class="text-rose-500">*</span></label>
                                    <select name="category_id" id="inputCategory" required onchange="updatePreviewCategory(this)" class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white transition">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-name="{{ $category->name }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kuota Maksimal Peserta <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="quota" id="inputQuota" value="{{ old('quota', 100) }}" min="1" required
                                            oninput="updatePreviewQuota(this.value)"
                                            class="w-full text-xs sm:text-sm p-3.5 pl-10 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none transition">
                                        <i class="fa-solid fa-users absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Lengkap Acara <span class="text-rose-500">*</span></label>
                                <textarea name="description" rows="4" required placeholder="Jelaskan tujuan acara, pembicara, syarat pendaftaran, dan benefit yang didapatkan peserta..." class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none transition leading-relaxed">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-5">
                            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-xl bg-brand-navy/5 text-brand-navy flex items-center justify-center font-bold text-sm">2</div>
                                <div>
                                    <h3 class="font-bold text-brand-navy text-sm">Jadwal & Tempat Pelaksanaan</h3>
                                    <p class="text-[11px] text-slate-400">Atur tanggal serta lokasi kegiatan offline atau online.</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Lokasi / Ruangan Kegiatan <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="location" id="inputLocation" value="{{ old('location') }}" required
                                        placeholder="Contoh: Auditorium Gedung Rektorat Lt. 3 / Zoom Cloud Meeting"
                                        oninput="updatePreviewLocation(this.value)"
                                        class="w-full text-xs sm:text-sm p-3.5 pl-10 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none transition">
                                    <i class="fa-solid fa-location-dot absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Waktu Mulai <span class="text-rose-500">*</span></label>
                                    <input type="datetime-local" name="start_date" id="inputStartDate" value="{{ old('start_date') }}" required
                                        onchange="updatePreviewDate(this.value)"
                                        class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Waktu Selesai <span class="text-rose-500">*</span></label>
                                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none transition">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-4">
                            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-xl bg-brand-navy/5 text-brand-navy flex items-center justify-center font-bold text-sm">3</div>
                                <div>
                                    <h3 class="font-bold text-brand-navy text-sm">Poster / Banner Acara</h3>
                                    <p class="text-[11px] text-slate-400">Pilih gambar visual terbaik agar menarik minat mahasiswa.</p>
                                </div>
                            </div>

                            <div class="relative border-2 border-dashed border-slate-300 hover:border-brand-coral rounded-2xl p-6 text-center cursor-pointer transition bg-slate-50/50 hover:bg-slate-50 group">
                                <input type="file" name="banner" id="bannerInput" accept="image/png, image/jpeg, image/jpg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleBannerChange(this)">

                                <div id="bannerPlaceholder">
                                    <div class="w-12 h-12 rounded-full bg-brand-coral/10 text-brand-coral flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition">
                                        <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700">Klik atau seret file poster ke sini</p>
                                    <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, JPEG (Maks. 3 MB)</p>
                                </div>

                                <div id="bannerPreviewBox" class="hidden">
                                    <img id="bannerImg" src="#" alt="Poster Preview" class="max-h-40 mx-auto rounded-xl shadow-sm border border-slate-200 object-cover mb-2">
                                    <p id="bannerName" class="text-xs font-semibold text-brand-navy truncate max-w-xs mx-auto"></p>
                                    <span class="text-[11px] text-brand-coral font-bold mt-1 inline-block">Klik untuk mengganti poster</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-5">
                            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-xl bg-brand-navy/5 text-brand-navy flex items-center justify-center font-bold text-sm">4</div>
                                <div>
                                    <h3 class="font-bold text-brand-navy text-sm">Skema Tiket & Pembayaran</h3>
                                    <p class="text-[11px] text-slate-400">Tentukan apakah kegiatan ini bebas biaya atau berbayar (HTM).</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <label id="cardFree" onclick="selectPricing(false)" class="p-4 rounded-2xl border-2 border-brand-navy bg-brand-navy/5 cursor-pointer transition flex items-center gap-3">
                                    <input type="radio" name="is_paid" value="0" {{ old('is_paid', '0') == '0' ? 'checked' : '' }} class="hidden" id="radioFree">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg font-bold shrink-0">
                                        <i class="fa-solid fa-gift"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-extrabold text-brand-navy">Gratis (Free)</span>
                                        <span class="text-[10px] text-slate-500">Tanpa biaya pendaftaran</span>
                                    </div>
                                </label>

                                <label id="cardPaid" onclick="selectPricing(true)" class="p-4 rounded-2xl border-2 border-slate-200 hover:border-slate-300 cursor-pointer transition flex items-center gap-3">
                                    <input type="radio" name="is_paid" value="1" {{ old('is_paid') == '1' ? 'checked' : '' }} class="hidden" id="radioPaid">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg font-bold shrink-0">
                                        <i class="fa-solid fa-ticket"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-extrabold text-brand-navy">Berbayar (HTM)</span>
                                        <span class="text-[10px] text-slate-500">Memerlukan bukti bayar</span>
                                    </div>
                                </label>
                            </div>

                            <div id="paidFields" class="{{ old('is_paid') == '1' ? '' : 'hidden' }} p-5 rounded-2xl bg-amber-50/50 border border-amber-200 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Harga Tiket (Rp) <span class="text-rose-500">*</span></label>
                                        <div class="relative">
                                            <input type="number" name="price" id="inputPrice" value="{{ old('price', 25000) }}" min="0" placeholder="25000"
                                                oninput="updatePreviewPrice(this.value)"
                                                class="w-full text-xs sm:text-sm p-3.5 pl-12 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white transition">
                                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Bank / E-Wallet <span class="text-rose-500">*</span></label>
                                        <input type="text" name="bank_name" value="{{ old('bank_name', 'Bank Mandiri') }}" placeholder="Contoh: BCA / Mandiri / Dana" class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white transition">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Rekening / No. HP <span class="text-rose-500">*</span></label>
                                        <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" placeholder="Contoh: 123-456-7890" class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white transition">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Pemilik Rekening <span class="text-rose-500">*</span></label>
                                        <input type="text" name="bank_account_holder" value="{{ old('bank_account_holder') }}" placeholder="Contoh: BEM Fakultas Teknik" class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white transition">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4">
                            <a href="{{ route('organisasi.dashboard') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200/60 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-7 py-3.5 rounded-xl bg-brand-coral hover:bg-[#e04d59] text-white text-xs sm:text-sm font-bold transition shadow-lg shadow-brand-coral/25 flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Ajukan Acara untuk Diverifikasi</span>
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        function updatePreviewTitle(val) {
            document.getElementById('liveTitle').textContent = val.trim() ? val : 'Judul Acara Akan Muncul di Sini...';
        }

        function updatePreviewCategory(sel) {
            const opt = sel.options[sel.selectedIndex];
            const name = opt.getAttribute('data-name');
            document.getElementById('liveCategory').textContent = name ? name : 'Kategori Acara';
        }

        function updatePreviewQuota(val) {
            document.getElementById('liveQuota').innerHTML = '<i class="fa-solid fa-users mr-1 text-brand-cyan"></i> ' + (val ? val : '0') + ' Kuota';
        }

        function updatePreviewLocation(val) {
            document.getElementById('liveLocation').innerHTML = '<i class="fa-solid fa-location-dot text-slate-300"></i> ' + (val.trim() ? val : 'Lokasi kegiatan belum diatur');
        }

        function updatePreviewDate(val) {
            if (!val) return;
            const d = new Date(val);
            const options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            document.getElementById('liveDate').innerHTML = '<i class="fa-regular fa-calendar mr-1 text-brand-cyan"></i> ' + d.toLocaleDateString('id-ID', options);
        }

        function updatePreviewPrice(val) {
            const priceEl = document.getElementById('livePrice');
            const num = parseInt(val);
            if (!isNaN(num) && num > 0) {
                priceEl.textContent = 'Rp ' + num.toLocaleString('id-ID');
                priceEl.className = 'absolute top-4 right-4 text-[11px] font-black px-3 py-1 rounded-full bg-amber-500 text-white shadow-sm';
            } else {
                priceEl.textContent = 'GRATIS';
                priceEl.className = 'absolute top-4 right-4 text-[11px] font-black px-3 py-1 rounded-full bg-emerald-500 text-white shadow-sm';
            }
        }

        function selectPricing(isPaid) {
            const cardFree = document.getElementById('cardFree');
            const cardPaid = document.getElementById('cardPaid');
            const paidFields = document.getElementById('paidFields');
            const radioFree = document.getElementById('radioFree');
            const radioPaid = document.getElementById('radioPaid');

            if (isPaid) {
                radioPaid.checked = true;
                cardPaid.className = 'p-4 rounded-2xl border-2 border-brand-navy bg-brand-navy/5 cursor-pointer transition flex items-center gap-3';
                cardFree.className = 'p-4 rounded-2xl border-2 border-slate-200 hover:border-slate-300 cursor-pointer transition flex items-center gap-3';
                paidFields.classList.remove('hidden');
                updatePreviewPrice(document.getElementById('inputPrice').value);
            } else {
                radioFree.checked = true;
                cardFree.className = 'p-4 rounded-2xl border-2 border-brand-navy bg-brand-navy/5 cursor-pointer transition flex items-center gap-3';
                cardPaid.className = 'p-4 rounded-2xl border-2 border-slate-200 hover:border-slate-300 cursor-pointer transition flex items-center gap-3';
                paidFields.classList.add('hidden');
                updatePreviewPrice(0);
            }
        }

        function handleBannerChange(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('bannerImg').src = e.target.result;
                    document.getElementById('bannerName').textContent = file.name;
                    document.getElementById('bannerPlaceholder').classList.add('hidden');
                    document.getElementById('bannerPreviewBox').classList.remove('hidden');

                    document.getElementById('livePreviewImg').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>