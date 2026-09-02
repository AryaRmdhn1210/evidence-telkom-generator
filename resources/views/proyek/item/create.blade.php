<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Tambah Item — {{ $proyek->nama_proyek }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

      @if ($errors->any())
      <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded">
        <p class="mb-1 font-medium">Periksa kembali isian berikut:</p>
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="p-6 bg-white rounded shadow"
        x-data="{
                    mode: '{{ old('mode', 'existing') }}',
                    drm: {{ (int) old('qty_drm', 0) }},
                    rekon: {{ (int) old('qty_rekon_aktual', 0) }},
                    tambah: {{ (int) old('qty_tambah', 0) }},
                    kurang: {{ (int) old('qty_kurang', 0) }},
                    kategori: '{{ old('kategori_foto', 'wajib_per_unit') }}',
                    get hasilHitung() { return Number(this.drm) + Number(this.tambah) - Number(this.kurang); },
                    get sesuai() { return this.hasilHitung === Number(this.rekon); },
                    get jumlahFotoWajib() { return this.kategori === 'representatif' ? 1 : Number(this.rekon || 0); }
                 }">
        <form method="POST" action="{{ route('proyek.item.store', $proyek) }}">
          @csrf

          <div class="flex gap-2 mb-4">
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
            <select name="item_pekerjaan_id" class="block w-full mt-1 border-gray-300 rounded">
              <option value="">-- Pilih Item --</option>
              @foreach ($itemPekerjaans as $ip)
              <option value="{{ $ip->id }}" {{ (string) old('item_pekerjaan_id') === (string) $ip->id ? 'selected' : '' }}>
                {{ $ip->kode_designator }} — {{ $ip->uraian_pekerjaan }} ({{ $ip->satuan }})
              </option>
              @endforeach
            </select>
            @error('item_pekerjaan_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @if ($itemPekerjaans->isEmpty())
            <p class="mt-1 text-xs text-gray-500">Belum ada master data item. Pakai opsi "Item Baru (Manual)" dulu.</p>
            @endif
          </div>

          <div x-show="mode === 'baru'" class="mb-4 space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Kode Designator</label>
              <input type="text" name="kode_designator" value="{{ old('kode_designator') }}" class="block w-full mt-1 border-gray-300 rounded">
              @error('kode_designator') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Kategori Pekerjaan</label>
              <input type="text" name="kategori_pekerjaan" value="{{ old('kategori_pekerjaan') }}" class="block w-full mt-1 border-gray-300 rounded" placeholder="misal: OSP FO FTTH">
              <p class="mt-1 text-xs text-gray-500">Dipakai untuk mengelompokkan item di tabel BOQ laporan. Boleh dikosongkan.</p>
              @error('kategori_pekerjaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Uraian Pekerjaan</label>
              <input type="text" name="uraian_pekerjaan" value="{{ old('uraian_pekerjaan') }}" class="block w-full mt-1 border-gray-300 rounded">
              @error('uraian_pekerjaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Satuan</label>
              <input type="text" name="satuan" value="{{ old('satuan') }}" class="block w-full mt-1 border-gray-300 rounded" placeholder="core / meter / pcs">
              @error('satuan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          <label class="block mb-2 text-sm font-medium text-gray-700">Quantity</label>
          <div class="grid grid-cols-4 gap-3 mb-2">
            <div>
              <label class="block text-xs text-gray-500">DRM</label>
              <input type="number" name="qty_drm" x-model.number="drm" min="0" class="block w-full mt-1 border-gray-300 rounded">
              @error('qty_drm') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs text-gray-500">Rekon/Aktual</label>
              <input type="number" name="qty_rekon_aktual" x-model.number="rekon" min="0" class="block w-full mt-1 border-gray-300 rounded">
              @error('qty_rekon_aktual') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs text-gray-500">Tambah</label>
              <input type="number" name="qty_tambah" x-model.number="tambah" min="0" class="block w-full mt-1 border-gray-300 rounded">
              @error('qty_tambah') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs text-gray-500">Kurang</label>
              <input type="number" name="qty_kurang" x-model.number="kurang" min="0" class="block w-full mt-1 border-gray-300 rounded">
              @error('qty_kurang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="p-3 mb-4 text-sm rounded"
            :class="sesuai ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'">
            Recheck otomatis: DRM + tambah − kurang = <span x-text="hasilHitung"></span>
            <span x-text="sesuai ? '(Sesuai)' : '(Selisih ' + Math.abs(hasilHitung - rekon) + ')'"></span>
          </div>

          <label class="block mb-2 text-sm font-medium text-gray-700">Kategori Foto</label>
          <div class="flex gap-3 mb-2">
            <label class="flex-1 p-3 text-sm border rounded cursor-pointer"
              :class="kategori === 'representatif' ? 'border-red-500 bg-red-50' : 'border-gray-300'">
              <input type="radio" name="kategori_foto" value="representatif" x-model="kategori" class="mr-2">
              Representatif — 1 foto
            </label>
            <label class="flex-1 p-3 text-sm border rounded cursor-pointer"
              :class="kategori === 'wajib_per_unit' ? 'border-red-500 bg-red-50' : 'border-gray-300'">
              <input type="radio" name="kategori_foto" value="wajib_per_unit" x-model="kategori" class="mr-2">
              Wajib per unit — sesuai rekon/aktual
            </label>
          </div>
          @error('kategori_foto') <p class="mb-2 text-sm text-red-600">{{ $message }}</p> @enderror
          <p class="mb-6 text-xs text-gray-500">
            Halaman berikutnya akan meminta <span x-text="jumlahFotoWajib"></span> foto.
          </p>

          <div class="flex justify-end gap-2">
            <a href="{{ route('proyek.show', $proyek) }}" class="px-4 py-2 border rounded">Batal</a>
            <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
              Simpan & Lanjut Upload Foto
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>