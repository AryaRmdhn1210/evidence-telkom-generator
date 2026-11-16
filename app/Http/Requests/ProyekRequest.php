<?php

namespace App\Http\Requests;

use App\Models\Proyek;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProyekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // Saat edit, nilai witel lama (teks bebas dari sebelum ada dropdown) tetap boleh dipertahankan
        $witelLama = $this->route('proyek')?->witel;
        $witelBoleh = array_filter(array_merge(array_keys(Proyek::DAFTAR_WITEL), [$witelLama]));

        return [
            'nama_proyek' => ['required', 'string', 'max:255'],
            'no_kontrak' => ['nullable', 'string', 'max:255'],
            'no_surat_pesanan' => ['nullable', 'string', 'max:255'],
            'witel' => ['required', 'string', 'max:255', Rule::in($witelBoleh)],
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

    public function messages(): array
    {
        return [
            'witel.required' => 'Witel wajib dipilih.',
            'witel.in' => 'Witel tidak valid. Pilih salah satu dari daftar.',
        ];
    }
}