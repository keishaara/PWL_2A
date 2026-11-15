<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Penyelenggara Univents</title>
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
                            noodle: '#FCCC6B',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full bg-brand-navy border-b border-white/10 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/univents-logo.png') }}" alt="Univents" class="h-8 w-auto object-contain">
                <span class="text-xl font-extrabold tracking-tight text-white">Uni<span class="text-brand-cyan">vents</span></span>
                <span class="ml-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-400/20 text-blue-300 border border-blue-400/30 uppercase tracking-wider">Penyelenggara</span>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-white/90">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">

        @include('organisasi.partials.sidebar', ['active' => 'payments'])

        <main class="flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Verifikasi Pembayaran & Rekap</h1>
                    <p class="text-xs text-slate-500 mt-1">Periksa bukti transfer mahasiswa dan kelola laporan keuangan kegiatan Anda.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('organisasi.payments.export', request()->only('event_id')) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                        <i class="fa-solid fa-file-excel text-sm"></i>
                        <span>Ekspor Laporan Excel (.xlsx)</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs sm:text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-blue-600 text-base"></i>
                <span>{{ session('info') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
            @endif

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-cyan"></div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Uang Masuk (Lunas)</span>
                    <span class="text-xl font-extrabold text-brand-navy mt-1 block">
                        Rp {{ number_format($stats['total_income'], 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] text-teal-600 font-semibold">{{ $stats['paid_count'] }} transaksi</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-blue-200 bg-blue-50/20 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500"></div>
                    <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider block">Perlu Verifikasi</span>
                    <span class="text-xl font-extrabold text-brand-navy mt-1 block">{{ $stats['waiting_count'] }}</span>
                    <span class="text-[11px] text-blue-500 font-semibold">Mahasiswa upload bukti</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-emerald-200 bg-emerald-50/20 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Total Lunas</span>
                    <span class="text-xl font-extrabold text-brand-navy mt-1 block">{{ $stats['paid_count'] }}</span>
                    <span class="text-[11px] text-emerald-600 font-semibold">Tiket diterbitkan</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-rose-200 bg-rose-50/20 shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500"></div>
                    <span class="text-[11px] font-bold text-rose-600 uppercase tracking-wider block">Ditolak</span>
                    <span class="text-xl font-extrabold text-brand-navy mt-1 block">{{ $stats['rejected_count'] }}</span>
                    <span class="text-[11px] text-rose-500 font-semibold">Bukti tidak valid</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
                <form action="{{ route('organisasi.payments.index') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('organisasi.payments.index', array_merge(request()->except('status', 'page'))) }}" 
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ !request('status') ? 'bg-brand-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Semua
                        </a>
                        <a href="{{ route('organisasi.payments.index', array_merge(request()->except('page'), ['status' => 'waiting_verification'])) }}" 
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'waiting_verification' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Perlu Verifikasi ({{ $stats['waiting_count'] }})
                        </a>
                        <a href="{{ route('organisasi.payments.index', array_merge(request()->except('page'), ['status' => 'paid'])) }}" 
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'paid' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Lunas ({{ $stats['paid_count'] }})
                        </a>
                        <a href="{{ route('organisasi.payments.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}" 
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Belum Bayar ({{ $stats['pending_count'] ?? 0 }})
                        </a>
                        <a href="{{ route('organisasi.payments.index', array_merge(request()->except('page'), ['status' => 'rejected'])) }}" 
                           class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Ditolak ({{ $stats['rejected_count'] }})
                        </a>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($myEvents->count() > 0)
                        <select name="event_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-cyan">
                            <option value="">-- Semua Acara Saya --</option>
                            @foreach ($myEvents as $ev)
                                <option value="{{ $ev->id }}" {{ request('event_id') == $ev->id ? 'selected' : '' }}>
                                    {{ Str::limit($ev->title, 28) }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice/nama..." class="pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-cyan w-44 md:w-56">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                        </div>
                        <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                <th class="py-3.5 px-4">Invoice & Acara</th>
                                <th class="py-3.5 px-4">Mahasiswa</th>
                                <th class="py-3.5 px-4">Nominal & Bank</th>
                                <th class="py-3.5 px-4 text-center">Bukti Transfer</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-4 text-right">Aksi Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($payments as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <div class="font-extrabold text-brand-navy">{{ $p->invoice_number }}</div>
                                    <div class="text-[11px] text-slate-500 font-semibold line-clamp-1 mt-0.5">
                                        {{ $p->event->title ?? '-' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        {{ $p->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-800">{{ $p->user->name ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $p->user->npm ?? 'NPM: -' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $p->user->email ?? '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-brand-navy">Rp {{ number_format($p->amount, 0, ',', '.') }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $p->bank_name ?? '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($p->payment_proof)
                                        @php
                                            $proofUrl = \Illuminate\Support\Str::startsWith($p->payment_proof, ['http://', 'https://'])
                                                ? $p->payment_proof
                                                : asset('storage/' . $p->payment_proof);
                                        @endphp
                                        <button type="button" 
                                                onclick="openProofModal('{{ $proofUrl }}', '{{ $p->invoice_number }}', '{{ $p->user->name ?? '-' }}', '{{ number_format($p->amount, 0, ',', '.') }}')" 
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200 font-bold transition text-[11px]">
                                            <i class="fa-solid fa-image"></i>
                                            <span>Lihat Bukti</span>
                                        </button>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">Belum diunggah</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $p->status_badge_class }}">
                                        {{ $p->status_label }}
                                    </span>
                                    @if($p->rejection_reason)
                                    <div class="text-[10px] text-rose-500 italic mt-1 max-w-[150px] mx-auto truncate" title="{{ $p->rejection_reason }}">
                                        {{ $p->rejection_reason }}
                                    </div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        @if($p->status === 'waiting_verification')
                                            <!-- Tombol Konfirmasi Lunas -->
                                            <form action="{{ route('organisasi.payments.confirm', $p->id) }}" method="POST" onsubmit="return confirm('Konfirmasi lunas pembayaran invoice {{ $p->invoice_number }}? E-Ticket akan otomatis terbit untuk mahasiswa.');">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-sm text-[11px]">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>Konfirmasi Lunas</span>
                                                </button>
                                            </form>

                                            <!-- Tombol Tolak -->
                                            <button type="button" 
                                                    onclick="openRejectModal('{{ route('organisasi.payments.reject', $p->id) }}', '{{ $p->invoice_number }}')" 
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-white border border-rose-300 text-rose-600 hover:bg-rose-50 font-bold transition text-[11px]">
                                                <i class="fa-solid fa-xmark"></i>
                                                <span>Tolak</span>
                                            </button>
                                        @elseif($p->status === 'pending')
                                            @if($p->payment_proof)
                                                <form action="{{ route('organisasi.payments.confirm', $p->id) }}" method="POST" onsubmit="return confirm('Konfirmasi lunas pembayaran invoice {{ $p->invoice_number }}? E-Ticket akan otomatis terbit untuk mahasiswa.');">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-sm text-[11px]">
                                                        <i class="fa-solid fa-check"></i>
                                                        <span>Konfirmasi Lunas</span>
                                                    </button>
                                                </form>
                                                <button type="button" 
                                                        onclick="openRejectModal('{{ route('organisasi.payments.reject', $p->id) }}', '{{ $p->invoice_number }}')" 
                                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-white border border-rose-300 text-rose-600 hover:bg-rose-50 font-bold transition text-[11px]">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    <span>Tolak</span>
                                                </button>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-slate-400 font-semibold text-[11px] px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg" title="Mahasiswa belum mengunggah bukti transfer">
                                                    <i class="fa-regular fa-clock"></i> Belum Bayar
                                                </span>
                                            @endif
                                        @elseif($p->status === 'rejected')
                                            <button type="button" 
                                                    onclick="openRejectModal('{{ route('organisasi.payments.reject', $p->id) }}', '{{ $p->invoice_number }}')" 
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 font-bold transition text-[10px]" title="Ubah alasan penolakan">
                                                <i class="fa-solid fa-pen"></i> Ubah Alasan
                                            </button>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-emerald-600 font-bold text-[11px] px-2 py-1 bg-emerald-50 rounded-lg">
                                                <i class="fa-solid fa-circle-check"></i> Terverifikasi
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 text-slate-300 block"></i>
                                    <p class="font-semibold text-sm text-slate-600">Belum ada transaksi pembayaran yang ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Pembayaran dari mahasiswa yang mendaftar di acara Anda akan muncul di sini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($payments->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $payments->links() }}
                </div>
                @endif
            </div>

        </main>
    </div>

    <div id="proofModal" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-brand-navy text-sm">Bukti Transfer Masuk</h3>
                    <p id="proofSubtitle" class="text-[11px] text-slate-400 mt-0.5"></p>
                </div>
                <button type="button" onclick="closeProofModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-5 bg-slate-100 flex items-center justify-center max-h-[70vh] overflow-auto">
                <img id="proofImage" src="" alt="Bukti Transfer" class="max-w-full h-auto rounded-lg shadow-sm border border-slate-200 object-contain">
            </div>
            <div class="px-5 py-3 border-t border-slate-100 flex justify-between items-center bg-white">
                <a id="proofDownloadLink" href="" target="_blank" download class="text-xs font-bold text-brand-cyan hover:underline flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Ukuran Penuh
                </a>
                <button type="button" onclick="closeProofModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-brand-navy text-sm">Tolak Pembayaran</h3>
                        <p id="rejectSubtitle" class="text-[11px] text-slate-400 mt-0.5"></p>
                    </div>
                    <button type="button" onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600 p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <div class="p-5 space-y-3">
                    <p class="text-xs text-slate-600">
                        Berikan alasan mengapa pembayaran ini ditolak agar mahasiswa dapat memahami dan mengunggah kembali bukti transfer yang sesuai:
                    </p>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Alasan Penolakan <span class="text-rose-500">*</span></label>
                        <textarea name="rejection_reason" rows="3" required placeholder="Contoh: Nominal transfer kurang, foto bukti buram, atau rekening pengirim tidak sesuai." class="w-full text-xs p-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-400 text-slate-700"></textarea>
                    </div>
                </div>
                <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2 bg-slate-50">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-sm">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openProofModal(imageUrl, invoice, name, amount) {
            document.getElementById('proofImage').src = imageUrl;
            document.getElementById('proofDownloadLink').href = imageUrl;
            document.getElementById('proofSubtitle').innerText = 'Invoice #' + invoice + ' - ' + name + ' (Rp ' + amount + ')';
            const modal = document.getElementById('proofModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeProofModal() {
            const modal = document.getElementById('proofModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openRejectModal(actionUrl, invoice) {
            const form = document.getElementById('rejectForm');
            form.action = actionUrl;
            document.getElementById('rejectSubtitle').innerText = 'Invoice #' + invoice;
            const modal = document.getElementById('rejectModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>
