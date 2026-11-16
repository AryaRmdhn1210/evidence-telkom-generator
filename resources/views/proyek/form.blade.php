@php
// Data pilihan witel untuk dropdown: nama (yang disimpan) + jenis (keterangan saja)
$witelOpsi = collect(\App\Models\Proyek::DAFTAR_WITEL)->map(fn ($jenis, $nama) => ['nama' => $nama, 'jenis' => $jenis])->values();
@endphp

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Nama Proyek</label>
    <input type="text" name="nama_proyek" value="{{ old('nama_proyek', $proyek->nama_proyek ?? '') }}"
        class="block w-full mt-1 border-gray-300 rounded">
    @error('nama_proyek') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">No Kontrak</label>
    <input type="text" name="no_kontrak" value="{{ old('no_kontrak', $proyek->no_kontrak ?? '') }}"
        class="block w-full mt-1 border-gray-300 rounded">
    @error('no_kontrak') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">No Surat Pesanan</label>
    <input type="text" name="no_surat_pesanan" value="{{ old('no_surat_pesanan', $proyek->no_surat_pesanan ?? '') }}"
        class="block w-full mt-1 border-gray-300 rounded">
    @error('no_surat_pesanan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-3 gap-3 mb-4">
    <!-- Witel: dropdown modal pencarian (13 wilayah administrasi Kalsel) -->
    <div x-data="{
            open: false,
            search: '',
            selected: @js(old('witel', $proyek->witel ?? '')),
            options: @js($witelOpsi),
            get filtered() {
                const q = this.search.toLowerCase();
                return q ? this.options.filter(o => (o.nama + ' ' + o.jenis).toLowerCase().includes(q)) : this.options;
            },
            isSelected(o) { return this.selected.toLowerCase() === o.nama.toLowerCase(); },
            pick(o) { this.selected = o.nama; this.open = false; this.search = ''; }
        }"
        @keydown.escape.window="open = false">
        <label class="block text-sm font-medium text-gray-700">Witel</label>
        <button type="button" @click="open = true"
            class="flex items-center justify-between w-full px-3 py-2 mt-1 text-left bg-white border border-gray-300 rounded hover:border-red-400">
            <span class="truncate" x-text="selected || '-- Pilih Witel --'"
                :class="selected ? 'text-gray-800' : 'text-gray-400'"></span>
            <svg class="w-4 h-4 ml-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <input type="hidden" name="witel" :value="selected">
        @error('witel') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

        <!-- Modal pemilih witel -->
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/30 backdrop-blur-sm"
                @click="open = false"></div>

            <div x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative bg-white/80 backdrop-blur-xl border border-white/60 rounded-2xl shadow-xl w-full max-w-sm max-h-[70vh] flex flex-col">
                <div class="p-5 border-b border-white/60">
                    <h3 class="mb-2 font-semibold text-gray-800">Pilih Witel</h3>
                    <input type="text" x-model="search" placeholder="Cari kabupaten atau kota..."
                        class="w-full text-sm border-gray-300 rounded-lg focus:border-red-400 focus:ring-red-400">
                </div>
                <div class="flex-1 overflow-y-auto">
                    <template x-for="o in filtered" :key="o.nama">
                        <button type="button" @click="pick(o)"
                            class="flex flex-col w-full px-5 py-3 text-left transition-colors border-b border-white/60 hover:bg-red-50/80"
                            :class="isSelected(o) ? 'bg-red-50/80' : ''">
                            <span class="text-sm font-medium text-gray-800" x-text="o.nama"></span>
                            <span class="text-xs text-gray-500" x-text="o.jenis + ' · Kalimantan Selatan'"></span>
                        </button>
                    </template>
                    <p x-show="filtered.length === 0" class="px-5 py-6 text-sm text-center text-gray-400">Tidak ada wilayah yang cocok.</p>
                </div>
                <div class="p-3 text-right border-t border-white/60">
                    <button type="button" @click="open = false" class="px-3 py-1.5 text-sm rounded-lg border border-gray-300 hover:bg-white">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Lokasi</label>
        <input type="text" name="lokasi" value="{{ old('lokasi', $proyek->lokasi ?? '') }}"
            class="block w-full mt-1 border-gray-300 rounded">
        @error('lokasi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">STO</label>
        <input type="text" name="sto" value="{{ old('sto', $proyek->sto ?? '') }}"
            class="block w-full mt-1 border-gray-300 rounded">
        @error('sto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700">Pelaksana</label>
    <input type="text" name="pelaksana" value="{{ old('pelaksana', $proyek->pelaksana ?? 'PT. Telkom Akses') }}"
        class="block w-full mt-1 border-gray-300 rounded">
    @error('pelaksana') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<hr class="my-6">

<h3 class="mb-4 font-semibold text-gray-700">Data Tanda Tangan Laporan</h3>
<p class="mb-4 text-xs text-gray-500">Data ini dipakai untuk kolom tanda tangan di laporan BAUT yang di-generate nanti.</p>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Tim Uji Terima</label>
        <input type="text" name="nama_tim_uji_terima" value="{{ old('nama_tim_uji_terima', $proyek->nama_tim_uji_terima ?? '') }}"
            class="block w-full mt-1 border-gray-300 rounded">
        @error('nama_tim_uji_terima') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">NIK Tim Uji Terima</label>
        <input type="text" name="nik_tim_uji_terima" value="{{ old('nik_tim_uji_terima', $proyek->nik_tim_uji_terima ?? '') }}"
            class="block w-full mt-1 border-gray-300 rounded">
        @error('nik_tim_uji_terima') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700">Tanda Tangan Tim Uji Terima (gambar, opsional)</label>
    @if (!empty($proyek->ttd_tim_uji_terima ?? null))
    <div class="mt-2 mb-2">
        <img src="{{ asset('storage/' . $proyek->ttd_tim_uji_terima) }}" class="h-16 p-1 bg-white border rounded">
        <p class="text-xs text-gray-500">Tanda tangan saat ini. Upload file baru untuk mengganti.</p>
    </div>
    @endif
    <input type="file" name="ttd_tim_uji_terima" accept="image/*" class="block w-full mt-1">
    @error('ttd_tim_uji_terima') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Penandatangan Pelaksana</label>
        <input type="text" name="nama_pelaksana_ttd" value="{{ old('nama_pelaksana_ttd', $proyek->nama_pelaksana_ttd ?? '') }}"
            class="block w-full mt-1 border-gray-300 rounded">
        @error('nama_pelaksana_ttd') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">NIK Penandatangan Pelaksana</label>
        <input type="text" name="nik_pelaksana_ttd" value="{{ old('nik_pelaksana_ttd', $proyek->nik_pelaksana_ttd ?? '') }}"
            class="block w-full mt-1 border-gray-300 rounded">
        @error('nik_pelaksana_ttd') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Tanda Tangan Pelaksana (gambar, opsional)</label>
    @if (!empty($proyek->ttd_pelaksana ?? null))
    <div class="mt-2 mb-2">
        <img src="{{ asset('storage/' . $proyek->ttd_pelaksana) }}" class="h-16 p-1 bg-white border rounded">
        <p class="text-xs text-gray-500">Tanda tangan saat ini. Upload file baru untuk mengganti.</p>
    </div>
    @endif
    <input type="file" name="ttd_pelaksana" accept="image/*" class="block w-full mt-1">
    @error('ttd_pelaksana') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>