<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nama_proyek' => ['required', 'string', 'max:255'],
            'no_kontrak' => ['nullable', 'string', 'max:255'],
            'no_surat_pesanan' => ['nullable', 'string', 'max:255'],
            'witel' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'sto' => ['nullable', 'string', 'max:255'],
            'pelaksana' => ['nullable', 'string', 'max:255'],
            'nama_tim_uji_terima' => ['nullable', 'string', 'max:255'],
            'nik_tim_uji_terima' => ['nullable', 'string', 'max:50'],
            'ttd_tim_uji_terima' => ['nullable', 'image', 'max:2048'],
            'nama_pelaksana_ttd' => ['nullable', 'string', 'max:255'],
            'nik_pelaksana_ttd' => ['nullable', 'string', 'max:50'],
            'ttd_pelaksana' => ['nullable', 'image', 'max:2048'],
        ];
    }
}