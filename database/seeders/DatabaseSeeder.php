<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'kepala@perpus.test'],
            [
                'name' => 'Kepala Perpustakaan',
                'role' => 'Kepala Perpustakaan',
                'status' => 'Aktif',
                'password' => Hash::make('Simpus123!'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@perpus.test'],
            [
                'name' => 'Admin Perpustakaan',
                'role' => 'Admin',
                'status' => 'Aktif',
                'password' => Hash::make('Simpus123!'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'anggota@perpus.test'],
            [
                'name' => 'Anggota Uji',
                'role' => 'Anggota',
                'status' => 'Aktif',
                'password' => Hash::make('Simpus123!'),
            ]
        );
    }
}
