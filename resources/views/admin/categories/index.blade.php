<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Admin Univents</title>
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

    @include('admin.partials.header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('admin.partials.sidebar', ['active' => 'categories'])

        <main class="flex-1 min-w-0">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Kelola Kategori Acara</h1>
                    <p class="text-xs text-slate-500 mt-1">Tambah, ubah, atau hapus kategori seperti Seminar, Lomba, Workshop, dan lainnya.</p>
                </div>
                <button type="button" onclick="openCategoryModal('create')" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-brand-navy hover:bg-slate-800 text-white transition shadow-sm shrink-0">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Kategori</span>
                </button>
            </div>

            @if(session('success'))
            <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->has('delete'))
            <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base mt-0.5"></i>
                <span>{{ $errors->first('delete') }}</span>
            </div>
            @endif

            {{-- Ringkasan kategori --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-2xl border border-sky-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-tag text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-500 block">Total Kategori</span>
                        <span class="text-3xl font-extrabold text-brand-navy mt-0.5 block">{{ $stats['total'] }}</span>
                    </div>
                </div>

                <div class="bg-emerald-50/40 p-4 rounded-2xl border border-emerald-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-calendar-check text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-emerald-700 block">Punya Acara</span>
                        <span class="text-3xl font-extrabold text-emerald-600 mt-0.5 block">{{ $stats['with_event'] }}</span>
                    </div>
                </div>

                <div class="bg-amber-50/40 p-4 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-ban text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-amber-700 block">Belum Dipakai</span>
                        <span class="text-3xl font-extrabold text-amber-600 mt-0.5 block">{{ $stats['empty'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Pencarian kategori --}}
            <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-5 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <div class="relative flex-1 min-w-0">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori..." class="w-full text-xs rounded-xl border border-slate-200 bg-white pl-9 pr-3 py-3 focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-6 py-3 rounded-xl text-xs font-bold bg-brand-navy text-white hover:bg-slate-800 transition">Cari</button>
                    @if(request('q'))
                        <a href="{{ route('admin.categories.index') }}" class="px-3 py-3 text-xs font-semibold text-slate-500 hover:text-brand-coral transition">Reset</a>
                    @endif
                </div>
            </form>

            {{-- Tabel kategori --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[650px] text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                                <th class="px-5 py-4 w-[45%]">Nama Kategori</th>
                                <th class="px-5 py-4 w-[25%]">Jumlah Acara</th>
                                <th class="px-5 py-4 w-[30%] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-brand-navy flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <span class="font-bold text-brand-navy text-sm">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-bold {{ $category->events_count > 0 ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $category->events_count }} acara
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2.5">
                                        <a href="{{ route('admin.categories.show', $category->id) }}" class="px-3 py-2 rounded-lg bg-brand-navy hover:bg-slate-800 text-white text-[11px] font-bold transition inline-flex items-center gap-1.5">
                                                <i class="fa-solid fa-eye"></i>
                                                <span>Detail</span>
                                        </a>    
                                        <button type="button"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            onclick="openCategoryModal('edit', this.dataset.id, this.dataset.name)"
                                            class="px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold transition inline-flex items-center gap-1.5">
                                            <i class="fa-solid fa-pen"></i>
                                            <span>Edit</span>
                                        </button>

                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus kategori \'{{ addslashes($category->name) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 rounded-lg bg-rose-500 hover:bg-rose-600 text-white text-[11px] font-bold transition inline-flex items-center gap-1.5">
                                                <i class="fa-solid fa-trash"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center text-slate-400">
                                    <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                    {{ request('q') ? 'Tidak ada kategori yang cocok dengan pencarian.' : 'Belum ada kategori. Klik "Tambah Kategori" untuk membuat yang pertama.' }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                <div class="px-5 py-4 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>

    {{-- Modal tambah / edit --}}
    <div id="categoryModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
            <h3 id="categoryModalTitle" class="text-base font-extrabold text-brand-navy mb-4">Tambah Kategori</h3>

            <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <input type="hidden" name="_method" id="categoryMethod" value="POST" disabled>
                <input type="hidden" name="_mode" id="categoryMode" value="create">
                <input type="hidden" name="_id" id="categoryId" value="">

                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="categoryName" value="{{ old('name') }}" required maxlength="100"
                        placeholder="Contoh: Seminar, Lomba, Workshop"
                        class="w-full text-xs rounded-xl border p-3 focus:outline-none focus:ring-1 {{ $errors->has('name') ? 'border-rose-400 focus:border-rose-400 focus:ring-rose-400' : 'border-slate-200 focus:border-brand-navy focus:ring-brand-navy' }}">
                    @error('name')
                        <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                    <span class="text-[10px] text-slate-400 mt-1 block">Slug dibuat otomatis dari nama kategori.</span>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-brand-navy hover:bg-slate-800 text-white transition shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const storeUrl  = @json(route('admin.categories.store'));
        const updateUrl = @json(url('/admin/categories')) + '/';

        function openCategoryModal(mode, id = '', name = '') {
            const form = document.getElementById('categoryForm');
            const method = document.getElementById('categoryMethod');

            document.getElementById('categoryMode').value = mode;
            document.getElementById('categoryId').value = id;

            if (mode === 'edit') {
                document.getElementById('categoryModalTitle').textContent = 'Edit Kategori';
                form.action = updateUrl + id;
                method.value = 'PUT';
                method.disabled = false;
            } else {
                document.getElementById('categoryModalTitle').textContent = 'Tambah Kategori';
                form.action = storeUrl;
                method.disabled = true;
            }

            document.getElementById('categoryName').value = name;
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryName').focus();
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        document.getElementById('categoryModal').addEventListener('click', function (e) {
            if (e.target === this) closeCategoryModal();
        });

        // Buka kembali modal bila validasi gagal, lengkap dengan isian sebelumnya
        @if($errors->has('name'))
            openCategoryModal(@json(old('_mode', 'create')), @json(old('_id', '')), @json(old('name', '')));
        @endif
    </script>
    @include('admin.partials.footer')
</body>
</html>