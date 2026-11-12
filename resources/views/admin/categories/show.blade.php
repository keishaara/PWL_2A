
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori - Admin Univents</title>
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

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    @include('admin.partials.header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('admin.partials.sidebar', ['active' => 'categories'])

        <main class="flex-1 min-w-0">

            <a href="{{ route('admin.categories.index') }}"
               class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-brand-navy mb-5">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Kelola Kategori
            </a>

            <div class="mb-6">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">
                    Detail Kategori
                </p>

                <h1 class="text-2xl font-extrabold text-brand-navy">
                    {{ $category->name }}
                </h1>

                <p class="text-xs text-slate-500 mt-1">
                    Daftar acara yang terhubung dengan kategori ini.
                </p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500">Total Acara</span>
                    <p class="text-2xl font-extrabold text-brand-navy mt-1">
                        {{ $stats['total'] }}
                    </p>
                </div>

                <div class="bg-emerald-50/40 p-4 rounded-2xl border border-emerald-200 shadow-sm">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="text-xs font-semibold text-emerald-700">Disetujui</span>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-1">
                        {{ $stats['approved'] }}
                    </p>
                </div>

                <div class="bg-amber-50/40 p-4 rounded-2xl border border-amber-200 shadow-sm">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <span class="text-xs font-semibold text-amber-700">Menunggu</span>
                    <p class="text-2xl font-extrabold text-amber-600 mt-1">
                        {{ $stats['pending'] }}
                    </p>
                </div>

                <div class="bg-rose-50/40 p-4 rounded-2xl border border-rose-200 shadow-sm">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <span class="text-xs font-semibold text-rose-700">Ditolak</span>
                    <p class="text-2xl font-extrabold text-rose-600 mt-1">
                        {{ $stats['rejected'] }}
                    </p>
                </div>

            </div>

            {{-- Daftar Acara --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="p-5 border-b border-slate-100">
                    <div class="mb-4">
                        <h2 class="text-base font-extrabold text-brand-navy">
                            Daftar Acara
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Acara yang menggunakan kategori {{ $category->name }}.
                        </p>
                    </div>

                    <form method="GET"
                          action="{{ route('admin.categories.show', $category->id) }}"
                          class="flex flex-col sm:flex-row gap-2">

                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>

                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   placeholder="Cari nama acara..."
                                   class="w-full text-xs rounded-xl border border-slate-200 bg-white pl-9 pr-3 py-3 focus:outline-none focus:border-brand-navy">
                        </div>

                        <select name="status"
                                class="text-xs rounded-xl border border-slate-200 bg-white px-3 py-3">
                            <option value="">Semua Status</option>
                            <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                            <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
                        </select>

                        <button type="submit"
                                class="px-5 py-3 rounded-xl text-xs font-bold bg-brand-navy text-white hover:bg-slate-800">
                            Cari
                        </button>

                        @if(request()->filled('q') || request()->filled('status'))
                            <a href="{{ route('admin.categories.show', $category->id) }}"
                               class="px-3 py-3 text-xs font-semibold text-slate-500 text-center">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] text-left text-xs">

                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                                <th class="px-5 py-4">Nama Acara</th>
                                <th class="px-5 py-4">Penyelenggara</th>
                                <th class="px-5 py-4">Tanggal Mulai</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($events as $event)
                                <tr class="hover:bg-slate-50/70 transition">

                                    <td class="px-5 py-4">
                                        <span class="font-bold text-brand-navy text-sm">
                                            {{ $event->title }}
                                        </span>
                                        <span class="block text-[11px] text-slate-400 mt-1">
                                            {{ $event->location }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-slate-600">
                                        {{ $event->organization->name ?? '—' }}
                                    </td>

                                    <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                        {{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '—' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if($event->status === 'approved')
                                            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold">
                                                Disetujui
                                            </span>
                                        @elseif($event->status === 'pending')
                                            <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-bold">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        <a href="{{ route('admin.events.show', $event->id) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-brand-navy hover:bg-slate-800 text-white text-[11px] font-bold">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>Lihat</span>
                                        </a>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-slate-400">
                                        <i class="fa-regular fa-calendar-xmark text-3xl mb-2 block"></i>

                                        <span class="block font-semibold text-slate-500">
                                            Belum ada acara
                                        </span>

                                        <span class="block text-xs mt-1">
                                            {{ request()->filled('q') || request()->filled('status')
                                                ? 'Tidak ada acara yang sesuai dengan pencarian atau filter.'
                                                : 'Belum ada acara yang terhubung dengan kategori ini.' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if($events->hasPages())
                    <div class="px-5 py-4 border-t border-slate-100">
                        {{ $events->links() }}
                    </div>
                @endif

            </div>

        </main>
    </div>

</body>
</html>
