<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Nama Proyek</label>
    <input type="text" name="nama_proyek" value="{{ old('nama_proyek', $proyek->nama_proyek ?? '') }}"
           class="mt-1 block w-full rounded border-gray-300">
    @error('nama_proyek') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">No Kontrak</label>
    <input type="text" name="no_kontrak" value="{{ old('no_kontrak', $proyek->no_kontrak ?? '') }}"
           class="mt-1 block w-full rounded border-gray-300">
    @error('no_kontrak') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">No Surat Pesanan</label>
    <input type="text" name="no_surat_pesanan" value="{{ old('no_surat_pesanan', $proyek->no_surat_pesanan ?? '') }}"
           class="mt-1 block w-full rounded border-gray-300">
    @error('no_surat_pesanan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-3 gap-3 mb-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Witel</label>
        <input type="text" name="witel" value="{{ old('witel', $proyek->witel ?? '') }}"
              class="mt-1 block w-full rounded border-gray-300">
        @error('witel') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Lokasi</label>
        <input type="text" name="lokasi" value="{{ old('lokasi', $proyek->lokasi ?? '') }}"
              class="mt-1 block w-full rounded border-gray-300">
        @error('lokasi') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">STO</label>
        <input type="text" name="sto" value="{{ old('sto', $proyek->sto ?? '') }}"
              class="mt-1 block w-full rounded border-gray-300">
        @error('sto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Pelaksana</label>
    <input type="text" name="pelaksana" value="{{ old('pelaksana', $proyek->pelaksana ?? 'PT. Telkom Akses') }}"
          class="mt-1 block w-full rounded border-gray-300">
    @error('pelaksana') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>