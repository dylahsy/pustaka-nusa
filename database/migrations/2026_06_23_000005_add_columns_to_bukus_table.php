<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->string('nomor_panggil')->nullable()->unique()->after('id');
            $table->string('kode_buku')->nullable()->unique()->after('nomor_panggil');
            $table->string('pengarang')->nullable()->after('judul_buku');
            $table->string('penerbit')->nullable()->after('pengarang');
            $table->integer('jumlah_buku')->default(0)->after('kategori_buku');
            $table->string('cover_buku')->nullable()->after('jumlah_buku');
            $table->text('sinopsis')->nullable()->after('cover_buku');
            $table->string('status')->default('tersedia')->after('sinopsis');
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropUnique(['nomor_panggil']);
            $table->dropUnique(['kode_buku']);
            $table->dropColumn(['nomor_panggil', 'kode_buku', 'pengarang', 'penerbit', 'jumlah_buku', 'cover_buku', 'sinopsis', 'status']);
        });
    }
};
