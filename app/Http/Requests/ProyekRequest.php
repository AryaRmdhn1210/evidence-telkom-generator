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
        ];
    }
}