<!DOCTYPE html>
<html lang="id">
<head>
    @include('mahasiswa.partials.head')
    <title>Rekap Ulasan - Univents</title>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    @include('organisasi.partials.header', ['title' => 'Rekap Ulasan'])
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-8">
        @include('organisasi.partials.sidebar', ['active' => 'reviews'])
        <main class="flex-1 min-w-0">
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
