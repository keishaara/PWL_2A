@php
    $items = [
        'events'        => ['Acara Saya', route('organisasi.dashboard'), 'fa-calendar-days'],
        'create_event'  => ['Buat Acara Baru', route('organisasi.events.create'), 'fa-plus-circle'],
        'payments'      => ['Verifikasi Pembayaran', route('organisasi.payments.index'), 'fa-receipt'],
        'attendance'    => ['Presensi Hari-H', route('organisasi.attendance.index'), 'fa-user-check'],
        'reviews'       => ['Rekap Ulasan', route('organisasi.reviews.index'), 'fa-star'],
      
    ];
@endphp
@php
    $recentNotifications = Auth::user()->inAppNotifications()->latest()->take(4)->get();
    $unreadNotifications = Auth::user()->inAppNotifications()->where('is_read', false)->count();
@endphp

<aside class="w-full md:w-64 shrink-0 space-y-4">
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm space-y-1">
        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 py-2">Navigasi Penyelenggara</div>

        @foreach ($items as $key => [$label, $url, $icon])
            @php $isActive = ($active ?? 'events') === $key; @endphp
            <a href="{{ $url }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $isActive ? 'font-bold bg-brand-navy text-white shadow-sm' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-navy' }}">
                <i class="fa-solid {{ $icon }} w-4 text-center {{ $isActive ? 'text-brand-cyan' : '' }}"></i>
                <span>{{ $label }}</span>
            </a>
        @endforeach

        <details class="mt-3 border-t border-slate-100 pt-3">
            <summary class="cursor-pointer list-none flex items-center justify-between px-3 py-2 text-sm font-semibold text-slate-600">
                <span><i class="fa-solid fa-bell w-4 mr-2"></i>Notifikasi</span>
                @if ($unreadNotifications)<span class="rounded-full bg-brand-coral px-2 py-0.5 text-[10px] text-white">{{ $unreadNotifications }}</span>@endif
            </summary>
            @forelse ($recentNotifications as $notification)
                <div class="mx-2 my-1 rounded-lg p-2 {{ $notification->is_read ? 'bg-slate-50' : 'bg-cyan-50' }}">
                    <p class="text-xs font-bold">{{ $notification->title }}</p>
                    <p class="text-[11px] text-slate-600 mt-1">{{ $notification->message }}</p>
                    @unless ($notification->is_read)
                        <form action="{{ route('notifications.read', $notification) }}" method="POST" class="mt-1">
                            @csrf
                            <button class="text-[10px] font-bold text-brand-navy hover:underline">Tandai dibaca</button>
                        </form>
                    @endunless
                </div>
            @empty
                <p class="px-3 py-2 text-xs text-slate-500">Belum ada notifikasi.</p>
            @endforelse
        </details>

        <form action="{{ route('logout') }}" method="POST" class="pt-2">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-brand-coral hover:bg-rose-50 transition text-left">
                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                <span>Keluar Akun</span>
            </button>
        </form>
    </div>
</aside>