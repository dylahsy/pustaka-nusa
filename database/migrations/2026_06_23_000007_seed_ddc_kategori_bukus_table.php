<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('kategori_bukus')->insertOrIgnore([
            [
                'kode_kategori' => '005.74',
                'nama_kategori' => 'Data Definition Language',
                'keterangan' => 'DDC 005.74 untuk basis data dan topik DDL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('kategori_bukus')
            ->where('kode_kategori', '005.74')
            ->where('nama_kategori', 'Data Definition Language')
            ->delete();
    }
};
