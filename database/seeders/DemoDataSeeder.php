<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DemoDataSeeder extends Seeder
{
    /**
     * Mengganti data operasional contoh tanpa menyentuh akun Kepala Perpustakaan.
     */
    public function run(): void
    {
        $now = now();

        // Hapus data anak terlebih dahulu agar tidak menyisakan relasi transaksi lama.
        DB::table('dendas')->delete();
        DB::table('transaksis')->delete();
        DB::table('anggota')->delete();
        DB::table('bukus')->delete();

        $bukuIds = [];
        $nomor = 1;
        $kategoriMetadata = [
            'Matematika' => ['KTG001', '510', 'Buku pelajaran Matematika.'],
            'Bahasa Indonesia' => ['KTG002', '410', 'Buku pelajaran Bahasa Indonesia.'],
            'Bahasa Inggris' => ['KTG003', '420', 'Buku pelajaran Bahasa Inggris.'],
            'Fisika' => ['KTG004', '530', 'Buku pelajaran Fisika.'],
            'Kimia' => ['KTG005', '540', 'Buku pelajaran Kimia.'],
            'Biologi' => ['KTG006', '570', 'Buku pelajaran Biologi.'],
            'Informatika' => ['KTG007', '004', 'Buku pelajaran Informatika.'],
            'Sejarah' => ['KTG008', '900', 'Buku pelajaran Sejarah.'],
            'Geografi' => ['KTG009', '910', 'Buku pelajaran Geografi.'],
            'Ekonomi' => ['KTG010', '330', 'Buku pelajaran Ekonomi.'],
            'Sosiologi' => ['KTG011', '300', 'Buku pelajaran Sosiologi.'],
            'Pendidikan Pancasila' => ['KTG022', '320', 'Pendidikan kewarganegaraan dan Pancasila.'],
            'Pendidikan Agama Islam' => ['KTG023', '297', 'Pendidikan agama Islam.'],
            'PJOK' => ['KTG024', '796', 'Pendidikan jasmani, olahraga, dan kesehatan.'],
            'Seni Rupa' => ['KTG025', '700', 'Pendidikan seni rupa.'],
            'Seni Musik' => ['KTG026', '780', 'Pendidikan seni musik.'],
            'Seni Tari' => ['KTG027', '793.3', 'Pendidikan seni tari.'],
            'Seni Teater' => ['KTG028', '792', 'Pendidikan seni teater.'],
            'Prakarya dan Kewirausahaan' => ['KTG029', '658.11', 'Prakarya dan kewirausahaan.'],
            'Pendidikan Agama Kristen' => ['KTG030', '230', 'Pendidikan agama Kristen.'],
            'Pendidikan Agama Katolik' => ['KTG031', '282', 'Pendidikan agama Katolik.'],
            'Pendidikan Agama Hindu' => ['KTG032', '294.5', 'Pendidikan agama Hindu.'],
            'Pendidikan Agama Buddha' => ['KTG033', '294.3', 'Pendidikan agama Buddha.'],
            'Pendidikan Agama Khonghucu' => ['KTG034', '299.512', 'Pendidikan agama Khonghucu.'],
        ];
        $klasifikasi = ['Matematika' => '510', 'Bahasa Indonesia' => '410', 'Bahasa Inggris' => '420', 'Fisika' => '530', 'Kimia' => '540', 'Biologi' => '570', 'Informatika' => '004', 'Sejarah' => '900', 'Geografi' => '910', 'Ekonomi' => '330', 'Sosiologi' => '300'] + collect($kategoriMetadata)->mapWithKeys(fn ($metadata, $nama) => [$nama => $metadata[1]])->all();
        $csvPath = database_path('seeders/data/buku_pelajaran_sma.csv');
        $csv = fopen($csvPath, 'r');
        $header = fgetcsv($csv);
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        while (($row = fgetcsv($csv)) !== false) {
            $item = array_combine($header, $row);
            $kategoriNama = trim($item['kategori']);
            $metadata = $kategoriMetadata[$kategoriNama] ?? ['KTG' . str_pad((string) (DB::table('kategori_buku')->max('id') + 1), 3, '0', STR_PAD_LEFT), $klasifikasi[$kategoriNama] ?? '000', 'Kategori buku pelajaran SMA ' . $kategoriNama . '.'];
            DB::table('kategori_buku')->updateOrInsert(
                ['nama_kategori' => $kategoriNama],
                ['kode_kategori' => $metadata[0], 'kode_klasifikasi' => $metadata[1], 'keterangan' => $metadata[2], 'deskripsi' => $metadata[2], 'created_at' => $now, 'updated_at' => $now]
            );
            $kategoriId = DB::table('kategori_buku')->where('nama_kategori', $kategoriNama)->value('id');
            $ddc = $klasifikasi[$kategoriNama] ?? '000';
            $bukuIds[] = DB::table('bukus')->insertGetId([
                    'nomor_panggil' => sprintf('%s.%03d', $ddc, $nomor),
                    'kode_buku' => sprintf('BK-%03d', $nomor),
                    'judul_buku' => trim($item['judul']),
                    'pengarang' => trim($item['pengarang']),
                    'nama_penulis' => trim($item['pengarang']),
                    'penerbit' => trim($item['penerbit']),
                    'tahun_terbit' => (int) $item['tahun'],
                    'kategori_buku' => $kategoriNama,
                    'kategori_buku_id' => $kategoriId,
                    'jumlah_buku' => 4 + ($nomor % 5),
                    'cover_buku' => $this->downloadImage(trim($item['cover']), 'uploads/book-covers', 'buku-' . str_pad((string) $nomor, 3, '0', STR_PAD_LEFT)),
                    'sinopsis' => trim($item['sinopsis']),
                    'status' => 'tersedia',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            $nomor++;
        }
        fclose($csv);

        $calonAnggota = [
            ['Alya Putri Maharani', 'Perempuan', 'X-A'], ['Bagas Pratama', 'Laki-laki', 'X-A'],
            ['Citra Lestari', 'Perempuan', 'X-B'], ['Dimas Saputra', 'Laki-laki', 'X-B'],
            ['Elsa Nuraini', 'Perempuan', 'X-C'], ['Farhan Maulana', 'Laki-laki', 'X-C'],
            ['Gita Savitri', 'Perempuan', 'X-D'], ['Hanif Ramadhan', 'Laki-laki', 'X-D'],
            ['Intan Permata Sari', 'Perempuan', 'X-E'], ['Jovan Alfarizi', 'Laki-laki', 'X-E'],
            ['Kezia Anindita', 'Perempuan', 'XI-MIPA 1'], ['Luthfi Hakim', 'Laki-laki', 'XI-MIPA 1'],
            ['Maya Salsabila', 'Perempuan', 'XI-MIPA 2'], ['Naufal Rizki', 'Laki-laki', 'XI-MIPA 2'],
            ['Olivia Cahyani', 'Perempuan', 'XI-MIPA 3'], ['Pandu Prakoso', 'Laki-laki', 'XI-MIPA 3'],
            ['Qonita Azzahra', 'Perempuan', 'XI-IPS 1'], ['Rafi Akbar', 'Laki-laki', 'XI-IPS 1'],
            ['Salma Nabila', 'Perempuan', 'XI-IPS 2'], ['Tegar Aditya', 'Laki-laki', 'XI-IPS 2'],
            ['Ulfah Khairunnisa', 'Perempuan', 'XI-IPS 3'], ['Vino Kurniawan', 'Laki-laki', 'XI-IPS 3'],
            ['Wulan Anggraini', 'Perempuan', 'XII-MIPA 1'], ['Xavier Pramana', 'Laki-laki', 'XII-MIPA 1'],
            ['Yasmin Aulia', 'Perempuan', 'XII-MIPA 2'], ['Zaki Fadillah', 'Laki-laki', 'XII-MIPA 2'],
            ['Anisa Rahmadani', 'Perempuan', 'XII-MIPA 3'], ['Bima Setyawan', 'Laki-laki', 'XII-MIPA 3'],
            ['Caca Amelia', 'Perempuan', 'XII-IPS 1'], ['Daffa Alamsyah', 'Laki-laki', 'XII-IPS 1'],
            ['Erina Putri', 'Perempuan', 'XII-IPS 2'], ['Fikri Hidayat', 'Laki-laki', 'XII-IPS 2'],
            ['Ghina Azzahra', 'Perempuan', 'XII-IPS 3'], ['Hafiz Alamsyah', 'Laki-laki', 'XII-IPS 3'],
            ['Ira Melati', 'Perempuan', 'XII-IPS 3'], ['Jihan Kamilah', 'Perempuan', 'XII-MIPA 2'],
            ['Kevin Maulana', 'Laki-laki', 'XI-MIPA 2'], ['Lina Oktaviani', 'Perempuan', 'X-A'],
        ];

        $anggotaIds = [];
        $kelasSma = ['X IPA 1', 'X IPA 2', 'X IPA 3', 'X IPA 4', 'X IPS 1', 'X IPS 2', 'X IPS 3', 'X IPS 4', 'XI IPA 1', 'XI IPA 2', 'XI IPA 3', 'XI IPA 4', 'XI IPS 1', 'XI IPS 2', 'XI IPS 3', 'XI IPS 4', 'XII IPA 1', 'XII IPA 2', 'XII IPA 3', 'XII IPA 4', 'XII IPS 1', 'XII IPS 2', 'XII IPS 3', 'XII IPS 4'];
        $alamatJambi = ['Jl. Berdikari, Payo Selincah', 'Jl. Sunan Giri, Simpang III Sipin', 'Jl. Kol. Amir Hamzah, Selamat', 'Jl. Pangeran Hidayat, Paal Lima', 'Jl. Lingkar Barat, Kenali Besar', 'Jl. Patimura, Beliung', 'Jl. Depati Parbo, Bagan Pete', 'Jl. Kapt. Pattimura, Mayang Mangurai', 'Jl. HOS Cokroaminoto, Suka Karya', 'Jl. Abdul Rahman Saleh, Legok', 'Jl. Sunan Ampel, Murni', 'Jl. A. Thalib, Telanaipura', 'Jl. Piere Tendean, Telanaipura', 'Jl. Dr. Sumbiyono, Jelutung', 'Jl. Hayam Wuruk, Jelutung', 'Jl. Gajah Mada, Jelutung', 'Jl. Amangkurat, Tanjung Pinang', 'Jl. Raden Mattaher, Sulanjana', 'Jl. Slamet Riyadi, Solok Sipin', 'Jl. Sumantri Brojonegoro, Sungai Putri', 'Jl. Prof. Dr. M. Yamin, Payo Lebar', 'Jl. Sultan Thaha, Pasar Jambi', 'Jl. Dr. Sutomo, Pasar Jambi', 'Jl. Orang Kayo Pingai, Talang Banjar', 'Jl. Raden Fatah, Seberang Kota', 'Jl. KH. Ibrahim, Olak Kemang', 'Jl. Guru Muchtar, Tanjung Johor', 'Jl. Sunan Bonang, Tahtul Yaman', 'Jl. Sultan Syahril, Talang Bakung', 'Jl. Lingkar Selatan, Paal Merah', 'Jl. Soekarno Hatta, Pasir Putih', 'Jl. Karya Bakti, Wijaya Pura', 'Jl. Adityawarman, Thehok', 'Jl. Slamet Riyadi, Rajawali', 'Jl. R. Wijaya, Pakuan Baru', 'Jl. Basuki Rahmat, Paal Lima', 'Jl. Sunan Kalijaga, Rawa Sari', 'Jl. Ismail Malik, Kenali Asam'];
        foreach ($calonAnggota as $index => [$nama, $jenisKelamin, $kelas]) {
            $urutan = $index + 1;
            $anggotaIds[] = DB::table('anggota')->insertGetId([
                'kode_anggota' => sprintf('AGT-%03d', $urutan),
                'nis' => '260' . str_pad((string) $urutan, 5, '0', STR_PAD_LEFT),
                'nama' => $nama,
                'jenis_kelamin' => $jenisKelamin,
                'status_anggota' => 'Aktif',
                'kelas' => $kelasSma[$index % count($kelasSma)],
                'no_hp' => '0812' . str_pad((string) (7000000 + $urutan), 7, '0', STR_PAD_LEFT),
                'alamat' => $alamatJambi[$index],
                'foto_kartu' => $this->demoMemberPhoto($jenisKelamin, $urutan),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Riwayat 30 pengembalian untuk laporan; 12 transaksi pertama terlambat dan didendakan.
        for ($i = 0; $i < 30; $i++) {
            $hariPinjam = $i < 12 ? 9 + ($i % 4) : 4 + ($i % 3);
            $tanggalKembali = now()->startOfMonth()->addDays($i % now()->day)->startOfDay();
            $tanggalPinjam = $tanggalKembali->copy()->subDays($hariPinjam);
            $transaksiId = DB::table('transaksis')->insertGetId([
                'anggota_id' => $anggotaIds[$i],
                'buku_id' => $bukuIds[$i],
                'tanggal_pinjam' => $tanggalPinjam->toDateString(),
                'tanggal_kembali' => $tanggalKembali->toDateString(),
                'status' => 'dikembalikan',
            ]);

            if ($i < 12) {
                $terlambat = 2 + ($i % 4);
                DB::table('dendas')->insert([
                    'transaksi_id' => $transaksiId,
                    'jumlah_denda' => $terlambat * 2000,
                    'keterangan' => 'Denda otomatis untuk keterlambatan ' . $terlambat . ' hari.',
                    'status' => $i % 3 === 0 ? 'Dibayar' : 'Belum Dibayar',
                    'created_at' => $tanggalKembali,
                    'updated_at' => $now,
                ]);
            }
        }

        // Tabel peminjaman dan halaman pengembalian sama-sama menampilkan 30 pinjaman aktif ini.
        for ($i = 0; $i < 30; $i++) {
            $bukuId = $bukuIds[$i + 30];
            DB::table('transaksis')->insert([
                'anggota_id' => $anggotaIds[$i],
                'buku_id' => $bukuId,
                'tanggal_pinjam' => now()->subDays(5 + ($i % 12))->startOfDay()->toDateString(),
                'tanggal_kembali' => null,
                'status' => 'dipinjam',
            ]);
            DB::table('bukus')->where('id', $bukuId)->update(['status' => 'dipinjam']);
        }

        // Tambahan dua admin; akun Kepala Perpustakaan sengaja tidak diakses.
        foreach ([
            ['name' => 'Nadia Puspitasari', 'nis_nip' => '198902102020122001', 'email' => 'nadia.puspitasari@perpus.test', 'jenis_kelamin' => 'Perempuan', 'no_hp' => '081234567801', 'alamat' => 'Jl. Melati No. 12, Semarang'],
            ['name' => 'Rizal Firmansyah', 'nis_nip' => '199105152021011003', 'email' => 'rizal.firmansyah@perpus.test', 'jenis_kelamin' => 'Laki-laki', 'no_hp' => '081234567802', 'alamat' => 'Jl. Kenanga No. 8, Semarang'],
        ] as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                $admin + ['role' => 'Admin', 'status' => 'Aktif', 'password' => Hash::make('Simpus123!')]
            );
        }
    }

    /** Mengunduh gambar sumber sekali dan menyimpan jalur publiknya. */
    private function downloadImage(string $url, string $directory, string $fileName): ?string
    {
        $targetDirectory = public_path($directory);
        File::ensureDirectoryExists($targetDirectory);

        foreach (['png', 'jpg', 'webp'] as $extension) {
            $existing = $targetDirectory . DIRECTORY_SEPARATOR . $fileName . '.' . $extension;
            if (File::exists($existing)) {
                return $directory . '/' . $fileName . '.' . $extension;
            }
        }

        try {
            $response = Http::timeout(20)->withUserAgent('SIMPUS-SMANES/1.0')->get($url);
            $contentType = strtolower((string) $response->header('Content-Type'));

            if (! $response->successful() || ! str_starts_with($contentType, 'image/')) {
                return null;
            }

            $extension = match (true) {
                str_contains($contentType, 'png') => 'png',
                str_contains($contentType, 'webp') => 'webp',
                default => 'jpg',
            };
            $relativePath = $directory . '/' . $fileName . '.' . $extension;
            File::put(public_path($relativePath), $response->body());

            return $relativePath;
        } catch (\Throwable) {
            return null;
        }
    }

    /** Menggunakan potret siswa SMA Indonesia lokal untuk kartu anggota demo. */
    private function demoMemberPhoto(string $jenisKelamin, int $urutan): string
    {
        $photoNumbers = $jenisKelamin === 'Perempuan' ? [2] : [1];
        $photoNumber = $photoNumbers[($urutan - 1) % count($photoNumbers)];

        return 'uploads/member-photos/sma-'.str_pad((string) $photoNumber, 2, '0', STR_PAD_LEFT).'.jpg';
    }
}
