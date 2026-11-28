<!DOCTYPE html>
<html lang="id">
<head>
    @include('organisasi.partials.head')
    <title>Rekap Ulasan - Penyelenggara Univents</title>
</head>
<body class="bg-brand-warmBg text-brand-navy antialiased min-h-screen flex flex-col justify-between">

    @include('organisasi.partials.header', ['title' => 'Rekap Ulasan'])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'reviews'])

        <main class="flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-brand-navy">Rekap Ulasan Peserta</h1>
                    <p class="text-xs text-slate-500 mt-1">Pantau kepuasan, masukan, dan testimoni dari peserta seluruh kegiatan organisasi Anda.</p>
                </div>
            </div>

            @php
                $totalReviews = $reviews->total();
                $avgRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
                $positiveCount = $reviews->filter(fn($r) => $r->rating >= 4)->count();
                $positivePercent = $reviews->count() > 0 ? round(($positiveCount / $reviews->count()) * 100) : 0;
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-brand-blue"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Ulasan</span>
                    <span class="text-2xl font-extrabold text-brand-navy mt-1 block">{{ $totalReviews }}</span>
                    <i class="fa-solid fa-comments absolute right-4 bottom-3 text-slate-100 text-3xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-amber-400"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Rata-rata Rating</span>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-2xl font-extrabold text-amber-500">{{ $avgRating > 0 ? $avgRating : '-' }}</span>
                        @if($avgRating > 0)
                        <div class="flex items-center text-amber-400 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>
                        @endif
                    </div>
                    <i class="fa-solid fa-star absolute right-4 bottom-3 text-slate-100 text-3xl"></i>
                </div>

                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-4 pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-emerald-500"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kepuasan Peserta</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">
                        {{ $totalReviews > 0 ? $positivePercent . '%' : '-' }}
                    </span>
                    <i class="fa-solid fa-face-smile absolute right-4 bottom-3 text-slate-100 text-3xl"></i>
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($reviews as $review)
                    <article class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm hover:border-slate-300 transition">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-brand-navy text-white font-extrabold text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($review->user->name ?? 'P', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-sm font-bold text-brand-navy">{{ $review->user->name }}</h3>
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                            <i class="fa-solid fa-circle-check text-[9px]"></i> Hadir
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        <i class="fa-solid fa-calendar-day mr-1"></i> {{ $review->event->title }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1 text-amber-400 text-xs">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-xs font-extrabold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-lg">
                                    {{ $review->rating }}.0
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 text-xs sm:text-sm text-slate-700 leading-relaxed bg-[#F8FAFC] p-4 rounded-xl border border-slate-100/80">
                            "{{ $review->comment }}"
                        </div>

                        <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400">
                            <span>
                                <i class="fa-regular fa-clock mr-1"></i> Diberikan pada {{ $review->created_at->translatedFormat('d M Y, H:i') }}
                            </span>
                            <span class="text-slate-400 font-medium">Tiket Terverifikasi</span>
                        </div>
                    </article>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                        <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 border border-amber-200 flex items-center justify-center text-2xl mx-auto mb-3">
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <h3 class="text-base font-bold text-brand-navy">Belum Ada Ulasan</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                            Ulasan akan otomatis muncul setelah peserta yang hadir memberikan feedback dan penilaian atas kegiatan yang telah selesai.
                        </p>
                    </div>
                @endforelse
            </div>

            @if ($reviews->hasPages())
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
            @endif

        </main>
    </div>

    @include('organisasi.partials.footer')

</body>
</html>
