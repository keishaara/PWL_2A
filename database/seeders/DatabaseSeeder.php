<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = User::updateOrCreate(
            ['email' => 'mahasiswa@univents.com'],
            [
                'name'     => 'Keisha Aurel',
                'password' => Hash::make('password123'),
                'role'     => 'student',
                'npm'      => '2417051001',
                'major'    => 'Ilmu Komputer',
                'phone'    => '081234567890',
            ]
        );

        $ormawaUser = User::updateOrCreate(
            ['email' => 'ormawa@univents.com'],
            [
                'name'     => 'BEM Universitas',
                'password' => Hash::make('password123'),
                'role'     => 'organizer',
                'npm'      => null,
                'major'    => null,
                'phone'    => '089876543210',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@univents.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
                'npm'      => null,
                'major'    => null,
                'phone'    => '081122334455',
            ]
        );

        $orgBem = Organization::updateOrCreate(
            ['user_id' => $ormawaUser->id],
            [
                'name'        => 'BEM Universitas',
                'description' => 'Badan Eksekutif Mahasiswa tingkat universitas, penggerak kegiatan mahasiswa.',
                'logo'        => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?w=120',
            ]
        );

        $categories = [
            ['name' => 'Seminar & Workshop', 'slug' => 'seminar-workshop'],
            ['name' => 'Kompetisi', 'slug' => 'kompetisi'],
            ['name' => 'Seni & Musik', 'slug' => 'seni-musik'],
            ['name' => 'Olahraga & Kesehatan', 'slug' => 'olahraga-kesehatan'],
            ['name' => 'Teknologi & Riset', 'slug' => 'teknologi-riset'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }

        $eventsData = [
            [
                'title'               => 'Seminar Nasional Artificial Intelligence & Future Careers 2026',
                'slug'                => 'seminar-nasional-ai-future-careers-2026',
                'category_slug'       => 'teknologi-riset',
                'description'         => 'Seminar interaktif membahas perkembangan Generative AI, machine learning, serta persiapan karier masa depan di era digitalisasi bersama pakar industri top nasional.',
                'location'            => 'Auditorium Gedung Rektorat Lt. 3 & Zoom Live',
                'start_date'          => Carbon::now()->addDays(5)->setHour(9)->setMinute(0),
                'end_date'            => Carbon::now()->addDays(5)->setHour(13)->setMinute(0),
                'quota'               => 150,
                'price'               => 35000, 
                'bank_name'           => 'Bank Mandiri',
                'bank_account_number' => '123-00-9876543-2',
                'bank_account_holder' => 'BEM Univents Event Committee',
                'banner'              => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1000',
                'status'              => 'approved',
            ],
            [
                'title'               => 'Hands-on Bootcamp: UI/UX Design from Scratch with Figma',
                'slug'                => 'hands-on-bootcamp-ui-ux-design-figma',
                'category_slug'       => 'seminar-workshop',
                'description'         => 'Pelatihan intensif selama 2 hari mendesain antarmuka aplikasi web dan mobile dari tahap wireframe hingga interactive prototype bersertifikat.',
                'location'            => 'Laboratorium Komputer Terpadu Gedung C',
                'start_date'          => Carbon::now()->addDays(8)->setHour(10)->setMinute(0),
                'end_date'            => Carbon::now()->addDays(9)->setHour(16)->setMinute(0),
                'quota'               => 40,
                'price'               => 50000,
                'bank_name'           => 'Bank BCA',
                'bank_account_number' => '8920192831',
                'bank_account_holder' => 'BEM Univents Panitia Bootcamp',
                'banner'              => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=1000',
                'status'              => 'approved',
            ],
            [
                'title'               => 'Hackathon Mahasiswa Nasional: Smart Campus Solutions',
                'slug'                => 'hackathon-smart-campus-solutions-2026',
                'category_slug'       => 'kompetisi',
                'description'         => 'Kompetisi coding 24 jam untuk menciptakan solusi inovatif berbasis IoT, Web, dan Mobile dalam ekosistem kampus cerdas dengan total hadiah jutaan rupiah.',
                'location'            => 'Hall Serbaguna Lantai 1',
                'start_date'          => Carbon::now()->addDays(14)->setHour(8)->setMinute(30),
                'end_date'            => Carbon::now()->addDays(15)->setHour(17)->setMinute(0),
                'quota'               => 60,
                'price'               => 75000, 
                'bank_name'           => 'Bank BNI',
                'bank_account_number' => '0293847561',
                'bank_account_holder' => 'Panitia Hackathon Univents',
                'banner'              => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1000',
                'status'              => 'approved',
            ],
            [
                'title'               => 'Kuliah Tamu: Transformasi Industri FinTech & Startup di Indonesia',
                'slug'                => 'kuliah-tamu-transformasi-fintech-startup',
                'category_slug'       => 'seminar-workshop',
                'description'         => 'Sesi berbagi wawasan langsung dari para founder dan CTO startup unicorn di Indonesia mengenai tren teknologi keuangan.',
                'location'            => 'Ruang Teater Perpustakaan Pusat',
                'start_date'          => Carbon::now()->addDays(3)->setHour(13)->setMinute(30),
                'end_date'            => Carbon::now()->addDays(3)->setHour(16)->setMinute(0),
                'quota'               => 100,
                'price'               => 0, 
                'bank_name'           => null,
                'bank_account_number' => null,
                'bank_account_holder' => null,
                'banner'              => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=1000',
                'status'              => 'approved',
            ],
            [
                'title'               => 'Univents Soundfest: Pentas Musik & Seni Apresiasi Mahasiswa',
                'slug'                => 'univents-soundfest-pentas-musik-2026',
                'category_slug'       => 'seni-musik',
                'description'         => 'Festival musik tahunan kampus menampilkan band indie lokal, UKM seni pertunjukan, dan stand bazar kuliner kreatif mahasiswa.',
                'location'            => 'Lapangan Terbuka Kampus Utama',
                'start_date'          => Carbon::now()->addDays(20)->setHour(16)->setMinute(0),
                'end_date'            => Carbon::now()->addDays(20)->setHour(22)->setMinute(30),
                'quota'               => 500,
                'price'               => 25000, 
                'bank_name'           => 'Bank BRI',
                'bank_account_number' => '0129-01-098765-50-1',
                'bank_account_holder' => 'Panitia Soundfest Univents',
                'banner'              => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=1000',
                'status'              => 'approved',
            ],
            [
                'title'               => 'Turnamen Futsal Antar Jurusan Piala Rektor Cup',
                'slug'                => 'turnamen-futsal-piala-rektor-cup',
                'category_slug'       => 'olahraga-kesehatan',
                'description'         => 'Ajang silaturahmi dan unjuk bakat olahraga futsal bergengsi antar fakultas dan jurusan se-universitas.',
                'location'            => 'GOR Olahraga Kampus',
                'start_date'          => Carbon::now()->addDays(10)->setHour(8)->setMinute(0),
                'end_date'            => Carbon::now()->addDays(12)->setHour(18)->setMinute(0),
                'quota'               => 32,
                'price'               => 100000,
                'bank_name'           => 'Bank Mandiri',
                'bank_account_number' => '123-00-9876543-2',
                'bank_account_holder' => 'BEM Univents Event Committee',
                'banner'              => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1000',
                'status'              => 'approved',
            ],
        ];

        foreach ($eventsData as $event) {
            $cat = $categoryModels[$event['category_slug']] ?? null;

            Event::updateOrCreate(
                ['slug' => $event['slug']],
                [
                    'organization_id'     => $orgBem->id,
                    'category_id'         => $cat ? $cat->id : 1,
                    'title'               => $event['title'],
                    'description'         => $event['description'],
                    'location'            => $event['location'],
                    'start_date'          => $event['start_date'],
                    'end_date'            => $event['end_date'],
                    'quota'               => $event['quota'],
                    'price'               => $event['price'],
                    'bank_name'           => $event['bank_name'],
                    'bank_account_number' => $event['bank_account_number'],
                    'bank_account_holder' => $event['bank_account_holder'],
                    'banner'              => $event['banner'],
                    'status'              => $event['status'],
                ]
            );
        }
    }
}
