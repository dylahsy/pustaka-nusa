<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nis_nip')) {
                $table->string('nis_nip')->nullable()->unique()->after('name');
            }
        });

        DB::table('users')
            ->where('role', 'Petugas')
            ->update(['role' => 'Kepala Perpustakaan']);

        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->unique()->after('name');
            });
        }

        DB::table('users')
            ->where('role', 'Kepala Perpustakaan')
            ->update(['role' => 'Petugas']);

        if (Schema::hasColumn('users', 'nis_nip')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['nis_nip']);
                $table->dropColumn('nis_nip');
            });
        }
    }
};
