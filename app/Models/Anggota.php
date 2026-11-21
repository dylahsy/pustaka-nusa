<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    // Kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'kode_anggota',
        'nis',
        'nama',
        'kelas',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'foto_kartu',
    ];

    protected $casts = [
    ];

    public $timestamps = true; // otomatis created_at & updated_at

    /**
     * Foto kartu anggota.
     *
     * Foto bawaan data demo yang lama diganti dengan foto siswa standar,
     * sedangkan foto yang diunggah pengguna tetap dipakai apa adanya.
     */
    public function cardPhotoPath(): string
    {
        if ($this->foto_kartu && ! str_starts_with($this->foto_kartu, 'uploads/member-photos/anggota-')) {
            return $this->foto_kartu;
        }

        return $this->jenis_kelamin === 'Perempuan'
            ? 'uploads/member-photos/sma-02.jpg'
            : 'uploads/member-photos/sma-01.jpg';
    }
}
