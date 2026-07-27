<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->integer('transaksi_id');
            $table->integer('jumlah_denda')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('status')->default('Belum Dibayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
