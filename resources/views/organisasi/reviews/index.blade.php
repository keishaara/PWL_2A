<!DOCTYPE html>
<html lang="id">
<head>
    @include('mahasiswa.partials.head')
    <title>Rekap Ulasan - Univents</title>
</head>
<body class="min-h-screen text-brand-navy">
    <header class="bg-brand-navy text-white p-4 font-bold">Rekap Ulasan Acara</header>
    <div class="max-w-7xl mx-auto p-4 md:p-8 flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'reviews'])
        <main class="flex-1">
            <h1 class="text-2xl font-extrabold mb-2">Ulasan Peserta</h1>
            <p class="text-sm text-slate-500 mb-6">Ulasan dari peserta yang telah hadir di acara organisasi.</p>
            <div class="space-y-4">
                @forelse ($reviews as $review)
                    <article class="bg-white border border-slate-200 rounded-xl p-5">
                        <div class="flex flex-wrap justify-between gap-2">
                            <h2 class="font-bold">{{ $review->event->title }}</h2>
                            <span class="text-amber-500" aria-label="Rating {{ $review->rating }} dari 5">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                        </div>
                        <p class="mt-3 text-sm text-slate-700">{{ $review->comment }}</p>
                        <p class="mt-3 text-xs text-slate-500">{{ $review->user->name }} · {{ $review->created_at->format('d M Y') }}</p>
                    </article>
                @empty
                    <p class="p-8 text-center bg-white rounded-xl text-slate-500">Belum ada ulasan.</p>
                @endforelse
            </div>
            <div class="mt-5">{{ $reviews->links() }}</div>
        </main>
    </div>
    @include('organisasi.partials.footer')
</body>
</html>
