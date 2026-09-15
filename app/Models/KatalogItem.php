<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KatalogItem extends Model
{
    use HasFactory;

    protected $table = 'katalog_item';

    protected $fillable = [
        'kode_designator',
        'uraian_pekerjaan',
        'kategori_pekerjaan',
        'satuan',
        'kategori_foto_default',
        'is_master',
    ];

    protected $casts = [
        'is_master' => 'boolean',
    ];

    public function itemProyek(): HasMany
    {
        return $this->hasMany(ItemProyek::class, 'katalog_item_id');
    }
}
