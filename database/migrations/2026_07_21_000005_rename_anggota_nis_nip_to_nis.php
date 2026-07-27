<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('anggota', 'nis_nip') && ! Schema::hasColumn('anggota', 'nis')) {
            Schema::table('anggota', function (Blueprint $table) {
                $table->renameColumn('nis_nip', 'nis');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('anggota', 'nis') && ! Schema::hasColumn('anggota', 'nis_nip')) {
            Schema::table('anggota', function (Blueprint $table) {
                $table->renameColumn('nis', 'nis_nip');
            });
        }
    }
};
