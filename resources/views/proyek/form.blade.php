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
    <div>
        <label class="block text-sm font-medium text-gray-700">Witel</label>
        <input type="text" name="witel" value="{{ old('witel', $proyek->witel ?? '') }}"
            class="block w-full mt-1 border-gray-300 rounded">
        @error('witel') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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