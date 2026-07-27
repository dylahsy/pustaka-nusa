<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->unique('nis', 'anggota_nis_unique');
            $table->unique('no_hp', 'anggota_no_hp_unique');
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropUnique('anggota_nis_unique');
            $table->dropUnique('anggota_no_hp_unique');
        });
    }
};
