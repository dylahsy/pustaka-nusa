<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_buku', function (Blueprint $table) {
            if (!Schema::hasColumn('kategori_buku', 'kode_kategori')) {
                $table->string('kode_kategori')->nullable()->unique()->after('id');
            }

            if (!Schema::hasColumn('kategori_buku', 'kode_klasifikasi')) {
                $table->string('kode_klasifikasi')->nullable()->after('kode_kategori');
            }

            if (!Schema::hasColumn('kategori_buku', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('nama_kategori');
            }
        });

        $klasifikasi = [
            'Matematika' => ['510', 'Buku pelajaran Matematika'],
            'Bahasa Indonesia' => ['410', 'Buku pelajaran Bahasa Indonesia'],
            'Bahasa Inggris' => ['420', 'Buku pelajaran Bahasa Inggris'],
            'Fisika' => ['530', 'Buku pelajaran Fisika'],
            'Kimia' => ['540', 'Buku pelajaran Kimia'],
            'Biologi' => ['570', 'Buku pelajaran Biologi'],
            'Informatika' => ['004', 'Buku teknologi dan informatika'],
            'Sejarah' => ['900', 'Buku pelajaran Sejarah'],
            'Geografi' => ['910', 'Buku pelajaran Geografi'],
            'Ekonomi' => ['330', 'Buku pelajaran Ekonomi'],
            'Sosiologi' => ['300', 'Buku pelajaran Sosiologi'],
            'Agama' => ['200', 'Buku agama'],
            'Seni Budaya' => ['700', 'Buku seni dan budaya'],
            'Olahraga' => ['796', 'Buku olahraga'],
            'Fiksi' => ['813', 'Buku bacaan fiksi'],
            'Novel' => ['813', 'Buku bacaan novel'],
            'Biografi' => ['920', 'Buku biografi'],
            'Referensi' => ['030', 'Buku referensi'],
            'Kamus' => ['413', 'Kamus'],
            'Majalah' => ['050', 'Majalah'],
            'Umum' => ['000', 'Bacaan umum'],
        ];

        $kategori = DB::table('kategori_buku')->orderBy('id')->get();

        foreach ($kategori as $index => $item) {
            $kode = $item->kode_kategori ?: 'KTG' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT);
            $detail = $klasifikasi[$item->nama_kategori] ?? [null, $item->deskripsi ?? null];

            DB::table('kategori_buku')
                ->where('id', $item->id)
                ->update([
                    'kode_kategori' => $kode,
                    'kode_klasifikasi' => $item->kode_klasifikasi ?: $detail[0],
                    'keterangan' => $item->keterangan ?: ($detail[1] ?? $item->deskripsi),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('kategori_buku', function (Blueprint $table) {
            if (Schema::hasColumn('kategori_buku', 'kode_kategori')) {
                $table->dropUnique(['kode_kategori']);
                $table->dropColumn('kode_kategori');
            }

            if (Schema::hasColumn('kategori_buku', 'kode_klasifikasi')) {
                $table->dropColumn('kode_klasifikasi');
            }

            if (Schema::hasColumn('kategori_buku', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
