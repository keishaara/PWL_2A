<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Acara - Admin Univents</title>
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

        @include('admin.partials.sidebar', ['active' => 'verification'])

        <main class="flex-1 min-w-0">

            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-brand-navy">Verifikasi Acara Kampus</h1>
                <p class="text-xs text-slate-500 mt-1">Tinjau, setujui, atau tolak pengajuan acara dari organisasi kemahasiswaan.</p>
            </div>


            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm">
                <p class="font-bold mb-1">Gagal memproses penolakan:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Semua Acara</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $stats['all'] }}</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-amber-200 bg-amber-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block">Perlu Verifikasi</span>
                    <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $stats['pending'] }}</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-emerald-200 bg-emerald-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Disetujui</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $stats['approved'] }}</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-rose-200 bg-rose-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-rose-600 uppercase tracking-wider block">Ditolak</span>
                    <span class="text-2xl font-extrabold text-rose-600 mt-1 block">{{ $stats['rejected'] }}</span>
                </div>
            </div>


            <div class="flex items-center gap-2 mb-6 text-xs font-semibold overflow-x-auto pb-1">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl transition {{ !request('status') ? 'bg-brand-navy text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-navy' }}">
                    Semua ({{ $stats['all'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-amber-500' }}">
                    Menunggu ({{ $stats['pending'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-600' }}">
                    Disetujui ({{ $stats['approved'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-rose-600' }}">
                    Ditolak ({{ $stats['rejected'] }})
                </a>
            </div>


            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                                <th class="p-4">Acara & Penyelenggara</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Jadwal & Kuota</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($events as $event)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        @if($event->banner)
                                            <img src="{{ asset('storage/' . $event->banner) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 shrink-0">
                                                <i class="fa-regular fa-image"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="font-bold text-brand-navy hover:text-brand-coral transition text-sm flex items-center gap-1">
                                                {{ $event->title }}
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                                            </a>
                                            <p class="text-[11px] text-slate-400 mt-0.5">
                                                Oleh: <span class="font-semibold text-slate-600">{{ $event->organization->name ?? 'Organisasi' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">
                                        {{ $event->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <p class="font-semibold text-slate-700">{{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Kuota: {{ $event->quota }} peserta</p>
                                </td>
                                <td class="p-4">
                                    @if($event->status === 'approved')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            <i class="fa-solid fa-circle-check"></i> Disetujui
                                        </span>
                                    @elseif($event->status === 'rejected')
                                        <div>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                                <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                            </span>
                                            @if($event->rejection_reason)
                                                <p class="text-[10px] text-rose-500 mt-1 italic max-w-xs">"{{ $event->rejection_reason }}"</p>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                            <i class="fa-solid fa-hourglass-half"></i> Perlu Verifikasi
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($event->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">

                                    <form action="{{ route('admin.events.approve', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui acara ini?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition flex items-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-check"></i>
                                                <span>Setujui</span>
                                            </button>
                                        </form>


                                        <button type="button" onclick="openRejectModal('{{ $event->id }}', '{{ addslashes($event->title) }}')" class="px-3 py-1.5 rounded-lg bg-rose-500 hover:bg-rose-600 text-white font-bold transition flex items-center gap-1 shadow-sm">
                                            <i class="fa-solid fa-xmark"></i>
                                            <span>Tolak</span>
                                        </button>
                                    </div>
                                    @else
                                        <span class="text-slate-400 text-[11px] italic">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400">
                                    <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                    Tidak ada acara yang perlu diverifikasi pada status ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($events->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $events->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>


    <div id="rejectModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
            <h3 class="text-base font-extrabold text-brand-navy mb-1">Tolak Pengajuan Acara</h3>
            <p id="modalEventTitle" class="text-xs text-slate-500 mb-4 font-semibold"></p>

            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alasan Penolakan <span class="text-rose-500">*</span></label>
                    <textarea name="rejection_reason" rows="3" required placeholder="Tuliskan alasan penolakan secara jelas agar penyelenggara dapat memperbaikinya..." class="w-full text-xs rounded-xl border-slate-200 p-3 border focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400"></textarea>
                    <span class="text-[10px] text-slate-400 mt-1 block">Minimal 5 karakter. Alasan ini wajib diisi.</span>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-500 hover:bg-rose-600 text-white transition shadow-sm">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(eventId, eventTitle) {
            document.getElementById('modalEventTitle').textContent = 'Acara: ' + eventTitle;
            document.getElementById('rejectForm').action = '/admin/events/' + eventId + '/reject';
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
    @include('admin.partials.footer')
</body>
</html>