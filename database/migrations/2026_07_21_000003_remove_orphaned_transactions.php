<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $validAnggota = DB::table('anggota')->pluck('id');
        $validBuku = DB::table('bukus')->pluck('id');

        $orphanedIds = DB::table('transaksis')
            ->whereNotIn('anggota_id', $validAnggota)
            ->orWhereNotIn('buku_id', $validBuku)
            ->pluck('id');

        if ($orphanedIds->isNotEmpty()) {
            DB::table('dendas')->whereIn('transaksi_id', $orphanedIds)->delete();
            DB::table('transaksis')->whereIn('id', $orphanedIds)->delete();
        }
    }

    public function down(): void
    {
        // Transaksi yatim yang dihapus tidak dikembalikan.
    }
};
