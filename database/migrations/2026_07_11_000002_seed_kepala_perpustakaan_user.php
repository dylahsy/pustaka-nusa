<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Add the system-owned Kepala Perpustakaan account.
     *
     * This is inserted only when it does not exist, so a password or profile
     * changed later by the account owner will not be overwritten.
     */
    public function up(): void
    {
        if (DB::table('users')->where('email', 'kepala@perpus.test')->exists()) {
            return;
        }

        $now = now();

        DB::table('users')->insert([
            'name' => 'Kepala Perpustakaan',
            'email' => 'kepala@perpus.test',
            'no_hp' => null,
            'role' => 'Kepala Perpustakaan',
            'status' => 'Aktif',
            'password' => Hash::make('Simpus123!'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        DB::table('users')
            ->where('email', 'kepala@perpus.test')
            ->where('role', 'Kepala Perpustakaan')
            ->delete();
    }
};
