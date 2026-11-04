<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Data uji untuk fitur booking mahasiswa (acara gratis).
 * Jalankan SETELAH DatabaseSeeder:
 *   php artisan db:seed --class=EventTestSeeder
 * Aman dijalankan berulang kali (updateOrCreate berdasarkan slug).
 */
class EventTestSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::where('name', 'BEM Universitas')->first();

        if (! $org) {
            $this->command?->error('Organisasi "BEM Universitas" belum ada. Jalankan dulu: php artisan db:seed');
            return;
        }

        $events = [
            [
                'title'    => 'Workshop Dasar Laravel untuk Pemula',
                'slug'     => 'uji-workshop-dasar-laravel',
                'category' => 'seminar-workshop',
                'desc'     => 'Belajar membangun aplikasi web pertama dengan Laravel: routing, controller, Blade, dan Eloquent. Acara gratis untuk uji coba pendaftaran.',
                'location' => 'Laboratorium Komputer Gedung B',
                'start'    => Carbon::now()->addDays(4)->setTime(9, 0),
                'end'      => Carbon::now()->addDays(4)->setTime(12, 0),
                'quota'    => 50,
                'banner'   => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1000',
            ],
            [
                'title'    => 'Webinar Persiapan Karier Fresh Graduate',
                'slug'     => 'uji-webinar-karier-fresh-graduate',
                'category' => 'seminar-workshop',
                'desc'     => 'Tips menyusun CV, portofolio, dan menghadapi wawancara kerja bersama praktisi HR. Acara gratis untuk uji coba pendaftaran.',
                'location' => 'Zoom Meeting & Aula Fakultas',
                'start'    => Carbon::now()->addDays(6)->setTime(13, 0),
                'end'      => Carbon::now()->addDays(6)->setTime(15, 30),
                'quota'    => 100,
                'banner'   => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=1000',
            ],
            [
                'title'    => 'Senam Pagi Bersama & Cek Kesehatan Gratis',
                'slug'     => 'uji-senam-pagi-cek-kesehatan',
                'category' => 'olahraga-kesehatan',
                'desc'     => 'Senam bersama dan pemeriksaan kesehatan dasar untuk mahasiswa. Acara gratis untuk uji coba pendaftaran.',
                'location' => 'Lapangan Utama Kampus',
                'start'    => Carbon::now()->addDays(7)->setTime(6, 30),
                'end'      => Carbon::now()->addDays(7)->setTime(9, 0),
                'quota'    => 200,
                'banner'   => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=1000',
            ],
            [
                'title'    => 'Diskusi Riset: Kuota Terbatas (Uji Kuota Penuh)',
                'slug'     => 'uji-diskusi-riset-kuota-1',
                'category' => 'teknologi-riset',
                'desc'     => 'Acara dengan kuota hanya 1 kursi. Daftar dengan satu akun, lalu coba dengan akun kedua untuk melihat pesan kuota penuh.',
                'location' => 'Ruang Rapat Dekanat',
                'start'    => Carbon::now()->addDays(9)->setTime(10, 0),
                'end'      => Carbon::now()->addDays(9)->setTime(12, 0),
                'quota'    => 1,
                'banner'   => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1000',
            ],
        ];

        foreach ($events as $e) {
            $category = Category::where('slug', $e['category'])->first();

            if (! $category) {
                $this->command?->warn("Kategori {$e['category']} tidak ditemukan, dilewati: {$e['title']}");
                continue;
            }

            Event::updateOrCreate(
                ['slug' => $e['slug']],
                [
                    'organization_id'     => $org->id,
                    'category_id'         => $category->id,
                    'title'               => $e['title'],
                    'description'         => $e['desc'],
                    'location'            => $e['location'],
                    'start_date'          => $e['start'],
                    'end_date'            => $e['end'],
                    'quota'               => $e['quota'],
                    'price'               => 0,
                    'bank_name'           => null,
                    'bank_account_number' => null,
                    'bank_account_holder' => null,
                    'banner'              => $e['banner'],
                    'status'              => 'approved',
                ]
            );
        }

        $this->command?->info('EventTestSeeder selesai: 4 acara gratis berstatus approved.');
    }
}