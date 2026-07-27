<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denda extends Model
{
    protected $table = 'dendas';

    protected $fillable = [
        'transaksi_id',
        'jumlah_denda',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'jumlah_denda' => 'integer',
    ];

    public $timestamps = true;

    public function Transaksi(): BelongsTo
    {
        return $this->belongsTo('App\Models\Transaksi')->withDefault();
    }
}
