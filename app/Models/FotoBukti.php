<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoBukti extends Model
{
    use HasFactory;

    protected $table = 'foto_bukti';

    protected $fillable = [
        'item_proyek_id',
        'file_path',
        'nomor_urut',
    ];

    public function itemProyek(): BelongsTo
    {
        return $this->belongsTo(ItemProyek::class, 'item_proyek_id');
    }
}