<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    use HasFactory;

    /** Kode status progres foto yang bisa dipakai sebagai filter di Daftar Proyek */
    public const STATUS_FOTO = ['belum_ada_item', 'belum_lengkap', 'siap_generate', 'sudah_generate'];

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
        'nama_tim_uji_terima',
        'nik_tim_uji_terima',
        'ttd_tim_uji_terima',
        'nama_pelaksana_ttd',
        'nik_pelaksana_ttd',
        'ttd_pelaksana',
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

    /**
     * Kondisi untuk item yang jumlah fotonya belum mencukupi.
     * Aturannya sama dengan ItemProyek::jumlah_foto_wajib:
     * representatif = 1 foto, wajib per unit = sejumlah qty rekon/aktual.
     */
    protected static function itemKurangFoto(): Closure
    {
        return function ($q) {
            $q->whereRaw(
                '(select count(*) from foto_bukti where foto_bukti.item_proyek_id = item_proyek.id) < case when item_proyek.kategori_foto = ? then 1 else item_proyek.qty_rekon_aktual end',
                ['representatif']
            );
        };
    }

    /**
     * Filter proyek berdasarkan status progres foto.
     * Urutan prioritas sama dengan ringkasanFoto() di bawah.
     */
    public function scopeStatusFoto(Builder $query, ?string $status): Builder
    {
        return match ($status) {
            'belum_ada_item' => $query->whereDoesntHave('itemProyek'),
            'belum_lengkap' => $query->whereHas('itemProyek', self::itemKurangFoto()),
            'siap_generate' => $query->whereHas('itemProyek')
                ->whereDoesntHave('itemProyek', self::itemKurangFoto())
                ->whereDoesntHave('laporan'),
            'sudah_generate' => $query->whereHas('itemProyek')
                ->whereDoesntHave('itemProyek', self::itemKurangFoto())
                ->whereHas('laporan'),
            default => $query,
        };
    }

    /**
     * Ringkasan progres foto untuk satu proyek (dipakai di Daftar Proyek).
     * Idealnya itemProyek dimuat dengan withCount('fotoBukti') dan proyek dengan
     * withCount('laporan') supaya tidak ada query tambahan per baris.
     */
    public function ringkasanFoto(): array
    {
        $items = $this->itemProyek;
        $totalItem = $items->count();
        $wajib = 0;
        $terunggah = 0;
        $itemKurang = 0;

        foreach ($items as $item) {
            $perluFoto = $item->jumlah_foto_wajib;
            $adaFoto = $item->foto_bukti_count ?? $item->fotoBukti->count();

            $wajib += $perluFoto;
            $terunggah += min($adaFoto, $perluFoto);

            if ($adaFoto < $perluFoto) {
                $itemKurang++;
            }
        }

        $jumlahLaporan = $this->laporan_count ?? $this->laporan()->count();

        $status = match (true) {
            $totalItem === 0 => 'belum_ada_item',
            $itemKurang > 0 => 'belum_lengkap',
            $jumlahLaporan > 0 => 'sudah_generate',
            default => 'siap_generate',
        };

        return [
            'status' => $status,
            'total_item' => $totalItem,
            'item_kurang' => $itemKurang,
            'wajib' => $wajib,
            'terunggah' => $terunggah,
            'persen' => $wajib > 0 ? (int) round($terunggah / $wajib * 100) : 100,
            'jumlah_laporan' => $jumlahLaporan,
        ];
    }
}