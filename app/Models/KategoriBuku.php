<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'kategori_buku';

    protected $fillable = [
        'kode_kategori',
        'kode_klasifikasi',
        'nama_kategori',
        'keterangan',
        'deskripsi',
    ];

    public $timestamps = true;

    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_buku_id');
    }
}
