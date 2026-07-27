<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('kategori_buku')) {
            Schema::create('kategori_buku', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kategori')->unique();
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }

        $now = now();
        $kategori = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Informatika',
            'Sejarah',
            'Geografi',
            'Ekonomi',
            'Sosiologi',
            'Agama',
            'Seni Budaya',
            'Olahraga',
            'Fiksi',
            'Novel',
            'Biografi',
            'Referensi',
            'Kamus',
            'Majalah',
            'Umum',
        ];

        foreach ($kategori as $nama) {
            DB::table('kategori_buku')->updateOrInsert(
                ['nama_kategori' => $nama],
                [
                    'deskripsi' => 'Kategori buku ' . $nama . ' untuk perpustakaan SMA.',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_buku');
    }
};
