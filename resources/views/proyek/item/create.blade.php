<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Tambah Item — {{ $proyek->nama_proyek }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6"
        x-data="{
                    mode: 'existing',
                    drm: 0,
                    rekon: 0,
                    tambah: 0,
                    kurang: 0,
                    kategori: 'wajib_per_unit',
                    get hasilHitung() { return Number(this.drm) + Number(this.tambah) - Number(this.kurang); },
                    get sesuai() { return this.hasilHitung === Number(this.rekon); },
                    get jumlahFotoWajib() { return this.kategori === 'representatif' ? 1 : Number(this.rekon || 0); }
                 }">
        <form method="POST" action="{{ route('proyek.item.store', $proyek) }}">
          @csrf

          <div class="mb-4 flex gap-2">
            <button type="button" @click="mode = 'existing'"
              :class="mode === 'existing' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700'"
              class="px-3 py-1.5 rounded text-sm">Pilih dari Master Data</button>
            <button type="button" @click="mode = 'baru'"
              :class="mode === 'baru' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700'"
              class="px-3 py-1.5 rounded text-sm">Item Baru (Manual)</button>
          </div>
          <input type="hidden" name="mode" x-model="mode">

          <div x-show="mode === 'existing'" class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Item Pekerjaan</label>
            <select name="item_pekerjaan_id" class="mt-1 block w-full rounded border-gray-300">
              <option value="">-- Pilih Item --</option>
              @foreach ($itemPekerjaans as $ip)
              <option value="{{ $ip->id }}">{{ $ip->kode_designator }} — {{ $ip->uraian_pekerjaan }} ({{ $ip->satuan }})</option>
              @endforeach
            </select>
            @error('item_pekerjaan_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            @if ($itemPekerjaans->isEmpty())
            <p class="text-xs text-gray-500 mt-1">Belum ada master data item. Pakai opsi "Item Baru (Manual)" dulu.</p>
            @endif
          </div>

          <div x-show="mode === 'baru'" class="space-y-4 mb-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Kode Designator</label>
              <input type="text" name="kode_designator" class="mt-1 block w-full rounded border-gray-300">
              @error('kode_designator') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Uraian Pekerjaan</label>
              <input type="text" name="uraian_pekerjaan" class="mt-1 block w-full rounded border-gray-300">
              @error('uraian_pekerjaan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Satuan</label>
              <input type="text" name="satuan" class="mt-1 block w-full rounded border-gray-300" placeholder="core / meter / pcs">
              @error('satuan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
          <div class="grid grid-cols-4 gap-3 mb-2">
            <div>
              <label class="block text-xs text-gray-500">DRM</label>
              <input type="number" name="qty_drm" x-model.number="drm" min="0" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div>
              <label class="block text-xs text-gray-500">Rekon/Aktual</label>
              <input type="number" name="qty_rekon_aktual" x-model.number="rekon" min="0" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div>
              <label class="block text-xs text-gray-500">Tambah</label>
              <input type="number" name="qty_tambah" x-model.number="tambah" min="0" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div>
              <label class="block text-xs text-gray-500">Kurang</label>
              <input type="number" name="qty_kurang" x-model.number="kurang" min="0" class="mt-1 block w-full rounded border-gray-300">
            </div>
          </div>

          <div class="mb-4 p-3 rounded text-sm"
            :class="sesuai ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'">
            Recheck otomatis: DRM + tambah − kurang = <span x-text="hasilHitung"></span>
            <span x-text="sesuai ? '(Sesuai)' : '(Selisih ' + Math.abs(hasilHitung - rekon) + ')'"></span>
          </div>

          <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Foto</label>
          <div class="flex gap-3 mb-2">
            <label class="flex-1 border rounded p-3 text-sm cursor-pointer"
              :class="kategori === 'representatif' ? 'border-red-500 bg-red-50' : 'border-gray-300'">
              <input type="radio" name="kategori_foto" value="representatif" x-model="kategori" class="mr-2">
              Representatif — 1 foto
            </label>
            <label class="flex-1 border rounded p-3 text-sm cursor-pointer"
              :class="kategori === 'wajib_per_unit' ? 'border-red-500 bg-red-50' : 'border-gray-300'">
              <input type="radio" name="kategori_foto" value="wajib_per_unit" x-model="kategori" class="mr-2">
              Wajib per unit — sesuai rekon/aktual
            </label>
          </div>
          <p class="text-xs text-gray-500 mb-6">
            Halaman berikutnya akan meminta <span x-text="jumlahFotoWajib"></span> foto.
          </p>

          <div class="flex justify-end gap-2">
            <a href="{{ route('proyek.show', $proyek) }}" class="px-4 py-2 rounded border">Batal</a>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
              Simpan & Lanjut Upload Foto
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>