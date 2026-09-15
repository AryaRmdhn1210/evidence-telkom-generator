<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemProyek extends Model
{
    use HasFactory;

    protected $table = 'item_proyek';

    protected $fillable = [
        'proyek_id',
        'katalog_item_id',
        'qty_drm',
        'qty_rekon_aktual',
        'qty_tambah',
        'qty_kurang',
        'kategori_foto',
        'urutan_item',
    ];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function katalogItem(): BelongsTo
    {
        return $this->belongsTo(KatalogItem::class, 'katalog_item_id');
    }

    public function fotoBukti(): HasMany
    {
        return $this->hasMany(FotoBukti::class, 'item_proyek_id');
    }

    /**
     * Hasil hitung otomatis: DRM + tambah - kurang.
     * Dipakai untuk badge "Sesuai" / "Selisih X" di form input (Layar 2).
     */
    public function getHasilRecheckAttribute(): int
    {
        return $this->qty_drm + $this->qty_tambah - $this->qty_kurang;
    }

    public function getRecheckSesuaiAttribute(): bool
    {
        return $this->hasil_recheck === $this->qty_rekon_aktual;
    }

    /**
     * Jumlah slot foto yang wajib diupload, tergantung kategori foto.
     * representatif -> selalu 1, wajib_per_unit -> sejumlah qty_rekon_aktual.
     */
    public function getJumlahFotoWajibAttribute(): int
    {
        return $this->kategori_foto === 'representatif' ? 1 : $this->qty_rekon_aktual;
    }

    /**
     * Status kelengkapan untuk halaman Review (Layar 4).
     */
    public function getStatusLengkapAttribute(): bool
    {
        return $this->fotoBukti()->count() >= $this->jumlah_foto_wajib;
    }
}
