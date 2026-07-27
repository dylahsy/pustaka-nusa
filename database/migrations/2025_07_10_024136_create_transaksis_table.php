<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // ID utama transaksi

            $table->integer('anggota_id'); // Relasi manual ke tabel anggota
            $table->integer('buku_id');   // Relasi manual ke tabel bukus

            $table->date('tanggal_pinjam'); // Tanggal mulai pinjam
            $table->date('tanggal_kembali')->nullable(); // Tanggal kembali, bisa kosong
            $table->string('status')->default('dipinjam'); // Status transaksi

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
