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
}
