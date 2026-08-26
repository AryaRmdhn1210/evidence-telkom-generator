<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'proyek';

    protected $fillable = [
        'nama_proyek',
        'no_kontrak',
        'no_surat_pesanan',
        'witel',
        'lokasi',
        'sto',
        'pelaksana',
        'dibuat_oleh',
    ];

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function itemProyek(): HasMany
    {
        return $this->hasMany(ItemProyek::class, 'proyek_id');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'proyek_id');
    }
}