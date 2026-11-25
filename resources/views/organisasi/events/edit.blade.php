<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Acara - Penyelenggara Univents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#14213D',
                            coral: '#FF6B5B',
                            blue: '#1E90FF',
                            warmBg: '#F8F6F1',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    @include('organisasi.partials.header', ['title' => 'Edit Acara'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('organisasi.partials.sidebar', ['active' => 'events'])

        <main class="flex-1 min-w-0">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Edit Acara</h1>
                    <p class="text-xs text-slate-500 mt-1">Perbarui detail informasi acara Anda.</p>
                </div>
                <a href="{{ route('organisasi.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-brand-navy flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>

            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <p class="font-bold mb-1">Ada beberapa kesalahan input:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('organisasi.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Acara <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" required class="w-full text-xs sm:text-sm p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Acara <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="w-full text-xs sm:text-sm p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kuota Peserta <span class="text-rose-500">*</span></label>
                        <input type="number" name="quota" value="{{ old('quota', $event->quota) }}" min="1" required class="w-full text-xs sm:text-sm p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}" required class="w-full text-xs sm:text-sm p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu Mulai <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required class="w-full text-xs sm:text-sm p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu Selesai <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}" required class="w-full text-xs sm:text-sm p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Poster / Banner Acara (Biarkan kosong jika tidak diganti)</label>
                    @if($event->banner)
                    <div class="mb-2 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                        <span class="text-[11px] text-slate-400">Poster saat ini</span>
                    </div>
                    @endif
                    <input type="file" name="banner" accept="image/png, image/jpeg, image/jpg" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-navy file:text-white hover:file:bg-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Lengkap Acara <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="5" required class="w-full text-xs sm:text-sm p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                    <label class="block text-xs font-bold text-slate-700">Tipe Pendaftaran Acara <span class="text-rose-500">*</span></label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="radio" name="is_paid" value="0" {{ old('is_paid', $event->isPaid() ? '1' : '0') == '0' ? 'checked' : '' }} onchange="togglePaidForm(false)" class="text-brand-navy focus:ring-brand-navy">
                            <span>Gratis (Free)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="radio" name="is_paid" value="1" {{ old('is_paid', $event->isPaid() ? '1' : '0') == '1' ? 'checked' : '' }} onchange="togglePaidForm(true)" class="text-brand-navy focus:ring-brand-navy">
                            <span>Berbayar (HTM)</span>
                        </label>
                    </div>

                    <div id="paidFields" class="{{ old('is_paid', $event->isPaid() ? '1' : '0') == '1' ? '' : 'hidden' }} pt-3 border-t border-slate-200 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Harga Tiket (Rp)</label>
                                <input type="number" name="price" value="{{ old('price', (int)$event->price) }}" min="0" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Bank / E-Wallet</label>
                                <input type="text" name="bank_name" value="{{ old('bank_name', $event->bank_name) }}" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Rekening / No. HP</label>
                                <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $event->bank_account_number) }}" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pemilik Rekening</label>
                                <input type="text" name="bank_account_holder" value="{{ old('bank_account_holder', $event->bank_account_holder) }}" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:border-brand-navy focus:outline-none bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('organisasi.dashboard') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-navy hover:bg-slate-800 text-white text-xs font-bold transition shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        function togglePaidForm(isPaid) {
            const paidFields = document.getElementById('paidFields');
            if (isPaid) {
                paidFields.classList.remove('hidden');
            } else {
                paidFields.classList.add('hidden');
            }
        }
    </script>
    @include('organisasi.partials.footer')
</body>

</html>