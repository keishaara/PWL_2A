<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Contoh Mahasiswa
        User::updateOrCreate(
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

        // 2. Akun Contoh Ormawa (Penyelenggara)
        User::updateOrCreate(
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

        // 3. Akun Contoh Admin
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
    }
}