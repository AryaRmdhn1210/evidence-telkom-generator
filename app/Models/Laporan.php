<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'proyek_id',
        'dibuat_oleh',
        'tanggal_uji_terima',
        'file_pdf',
        'file_word',
    ];

    protected $casts = [
        'tanggal_uji_terima' => 'date',
    ];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}