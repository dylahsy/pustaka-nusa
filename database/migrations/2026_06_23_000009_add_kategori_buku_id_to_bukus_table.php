<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bukus', 'kategori_buku_id')) {
            Schema::table('bukus', function (Blueprint $table) {
                $table->foreignId('kategori_buku_id')
                    ->nullable()
                    ->after('kategori_buku')
                    ->constrained('kategori_buku')
                    ->nullOnDelete();
            });
        }

        $buku = DB::table('bukus')
            ->whereNull('kategori_buku_id')
            ->whereNotNull('kategori_buku')
            ->get(['id', 'kategori_buku']);

        foreach ($buku as $item) {
            $kategoriId = DB::table('kategori_buku')
                ->where('nama_kategori', $item->kategori_buku)
                ->value('id');

            if ($kategoriId) {
                DB::table('bukus')
                    ->where('id', $item->id)
                    ->update(['kategori_buku_id' => $kategoriId]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bukus', 'kategori_buku_id')) {
            Schema::table('bukus', function (Blueprint $table) {
                $table->dropConstrainedForeignId('kategori_buku_id');
            });
        }
    }
};
