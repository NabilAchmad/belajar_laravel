<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'admin',
        ]);

        // 2. Akun Staff
        User::create([
            'name' => 'Staff Perpus',
            'email' => 'staff@perpus.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // 3. Akun Member
        User::create([
            'name' => 'Member Satu',
            'email' => 'member@perpus.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // 4. Buat 10 member acak menggunakan factory
        User::factory(10)->create(); // Factory akan otomatis membuat member
    }
}