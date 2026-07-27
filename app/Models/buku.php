<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    // Kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'nomor_panggil',
        'kode_buku',
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori_buku_id',
        'kategori_buku',
        'jumlah_buku',
        'cover_buku',
        'sinopsis',
        'status',
        'nama_penulis',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'jumlah_buku' => 'integer',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_buku_id');
    }

    public $timestamps = true; // otomatis created_at & updated_at
}
