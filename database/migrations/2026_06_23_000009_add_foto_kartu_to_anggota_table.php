<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('anggota')) return;
        Schema::table('anggota', function (Blueprint $table) {
            if (! Schema::hasColumn('anggota', 'foto_kartu')) {
                $table->string('foto_kartu')->nullable()->after('alamat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            if (Schema::hasColumn('anggota', 'foto_kartu')) {
                $table->dropColumn('foto_kartu');
            }
        });
    }
};
