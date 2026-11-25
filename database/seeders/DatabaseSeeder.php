<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@univents.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
                'npm'      => null,
                'major'    => null,
                'phone'    => '081122334455',
            ]
        );

        $categories = [
            ['name' => 'Seminar & Workshop', 'slug' => 'seminar-workshop'],
            ['name' => 'Kompetisi', 'slug' => 'kompetisi'],
            ['name' => 'Seni & Musik', 'slug' => 'seni-musik'],
            ['name' => 'Olahraga & Kesehatan', 'slug' => 'olahraga-kesehatan'],
            ['name' => 'Teknologi & Riset', 'slug' => 'teknologi-riset'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }
    }
}