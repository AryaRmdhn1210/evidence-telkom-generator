<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    /** Pilihan jumlah data per halaman di daftar */
    public const OPSI_PER_HALAMAN = [5, 10, 25, 50];

    /**
     * Baca ?per_page dari URL, hanya terima nilai dari daftar pilihan.
     */
    protected function perHalaman(Request $request, int $default = 10): int
    {
        $nilai = (int) $request->query('per_page', $default);

        return in_array($nilai, self::OPSI_PER_HALAMAN, true) ? $nilai : $default;
    }
}