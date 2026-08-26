<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'item_pekerjaan';

    protected $fillable = [
        'kode_designator',
        'uraian_pekerjaan',
        'satuan',
        'kategori_foto_default',
        'is_master',
    ];

    protected $casts = [
        'is_master' => 'boolean',
    ];

    public function itemProyek(): HasMany
    {
        return $this->hasMany(ItemProyek::class, 'item_pekerjaan_id');
    }
}