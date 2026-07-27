<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $validTransactions = DB::table('transaksis')->pluck('id');
        DB::table('dendas')->whereNotIn('transaksi_id', $validTransactions)->delete();
    }

    public function down(): void
    {
        // Denda tanpa transaksi tidak dikembalikan.
    }
};
