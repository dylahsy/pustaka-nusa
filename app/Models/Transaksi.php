<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Anggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public $timestamps = false;

    public function getJatuhTempoAttribute(): ?Carbon
    {
        return $this->tanggal_pinjam ? $this->tanggal_pinjam->copy()->addDays(7) : null;
    }

    public function getHariTerlambatAttribute(): int
    {
        if (! $this->jatuh_tempo) {
            return 0;
        }

        $tanggalPembanding = $this->tanggal_kembali ?: now();

        return (int) max(0, $this->jatuh_tempo->diffInDays($tanggalPembanding, false));
    }

    public function getNominalDendaAttribute(): int
    {
        return $this->hari_terlambat * 2000;
    }

    public function getKodePinjamAttribute(): string
    {
        if (! $this->id) {
            return '-';
        }

        return 'PJM-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relasi ke anggota (peminjam buku).
     */
    public function Anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'anggota_id')->withDefault();
    }

    /**
     * Relasi ke buku (yang dipinjam).
     */
    public function Buku(): BelongsTo
    {
        return $this->belongsTo('App\Models\Buku')->withDefault();
    }
}
