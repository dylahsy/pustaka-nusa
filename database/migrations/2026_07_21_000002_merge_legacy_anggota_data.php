<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('members') || ! Schema::hasTable('anggota')) {
            return;
        }

        foreach (DB::table('members')->get() as $legacy) {
            if (DB::table('anggota')->where('id', $legacy->id)->exists()) {
                continue;
            }

            DB::table('anggota')->insert([
                'id' => $legacy->id,
                'kode_anggota' => $legacy->kode_member,
                'nis_nip' => $legacy->nis_nip ?? null,
                'nama' => $legacy->nama,
                'jenis' => $legacy->jenis ?? 'Siswa',
                'kelas' => $legacy->kelas ?? null,
                'jenis_kelamin' => $legacy->jenis_kelamin,
                'no_hp' => $legacy->no_hp ?? null,
                'alamat' => $legacy->alamat ?? '-',
                'status_anggota' => $legacy->status_member ?? 'Aktif',
                'foto_kartu' => $legacy->foto_kartu ?? null,
                'created_at' => $legacy->created_at,
                'updated_at' => $legacy->updated_at,
            ]);
        }

        Schema::drop('members');
    }

    public function down(): void
    {
        // Data sudah digabung ke tabel anggota dan tidak dikembalikan ke tabel lama.
    }
};
