<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTextbookBibliographySeeder extends Seeder
{
    /** Memperbarui penulis dan penerbit tiga buku demo yang sebelumnya memakai nama kementerian. */
    public function run(): void
    {
        foreach ([
            'Matematika Edisi Revisi SMA/MA/SMK/MAK Kelas X' => ['Tim Penulis', 'Erlangga'],
            'Panduan Guru Bahasa Indonesia Edisi Revisi SMA/MA/SMK/MAK Kelas X' => ['Tim Penulis', 'Pusat Kurikulum dan Perbukuan'],
            'Informatika SMA Kelas X' => ['Tim Penulis', 'Penerbit Andi'],
        ] as $judul => [$pengarang, $penerbit]) {
            DB::table('bukus')
                ->where('judul_buku', $judul)
                ->update([
                    'pengarang' => $pengarang,
                    'nama_penulis' => $pengarang,
                    'penerbit' => $penerbit,
                    'updated_at' => now(),
                ]);
        }
    }
}
