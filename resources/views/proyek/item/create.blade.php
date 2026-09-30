<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Tambah Item — {{ $proyek->nama_proyek }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

      <x-step-indicator current="2" />

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

      <script>
        function itemPickerData() {
            return {
                mode: '{{ old('mode', 'existing') }}',
                items: @json($katalogItems),
                itemModalOpen: false,
                itemSearch: '',
                selectedItemId: '{{ old('katalog_item_id') }}',
                get selectedItem() { return this.items.find(i => i.id == this.selectedItemId) },
                get filteredItems() {
                    const q = this.itemSearch.toLowerCase();
                    if (!q) return this.items;
                    return this.items.filter(i => (i.kode_designator + ' ' + i.uraian_pekerjaan + ' ' + (i.kategori_pekerjaan || '')).toLowerCase().includes(q));
                },
                selectItem(item) { this.selectedItemId = item.id; this.itemModalOpen = false; this.itemSearch = ''; },
                drm: {{ (int) old('qty_drm', 0) }},
                rekon: {{ (int) old('qty_rekon_aktual', 0) }},
                tambah: {{ (int) old('qty_tambah', 0) }},
                kurang: {{ (int) old('qty_kurang', 0) }},
                kategori: '{{ old('kategori_foto', 'wajib_per_unit') }}',
                get hasilHitung() { return Number(this.drm) + Number(this.tambah) - Number(this.kurang); },
                get sesuai() { return this.hasilHitung === Number(this.rekon); },
                get jumlahFotoWajib() { return this.kategori === 'representatif' ? 1 : Number(this.rekon || 0); }
            }
        }
      </script>

      <div class="p-6 bg-white rounded shadow" x-data="itemPickerData()" @keydown.escape.window="itemModalOpen = false">
        <form method="POST" action="{{ route('proyek.item.store', $proyek) }}" x-data="{ loading: false }" @submit="loading = true">
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
            <label class="block mb-1 text-sm font-medium text-gray-700">Item Pekerjaan</label>
            <button type="button" @click="itemModalOpen = true"
                class="flex items-center justify-between w-full px-3 py-2 text-left border border-gray-300 rounded hover:border-red-400">
                <span x-text="selectedItem ? (selectedItem.kode_designator + ' — ' + selectedItem.uraian_pekerjaan + ' (' + selectedItem.satuan + ')') : '-- Pilih Item --'"
                      :class="selectedItem ? 'text-gray-800' : 'text-gray-400'"></span>
                <svg class="w-4 h-4 ml-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <input type="hidden" name="katalog_item_id" :value="selectedItemId">
            @error('katalog_item_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @if ($katalogItems->isEmpty())
            <p class="mt-1 text-xs text-gray-500">Belum ada master data item. Pakai opsi "Item Baru (Manual)" dulu.</p>
            @endif

            <!-- Modal pemilih item -->
            <div x-show="itemModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div x-show="itemModalOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-black/30 backdrop-blur-sm"
                     @click="itemModalOpen = false"></div>

                <div x-show="itemModalOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-white/80 backdrop-blur-xl border border-white/60 rounded-2xl shadow-xl w-full max-w-sm max-h-[70vh] flex flex-col">
                    <div class="p-5 border-b border-white/60">
                        <h3 class="mb-2 font-semibold text-gray-800">Pilih Item Pekerjaan</h3>
                        <input type="text" x-model="itemSearch" placeholder="Cari kode, uraian, atau kategori..."
                            class="w-full text-sm border-gray-300 rounded-lg focus:border-red-400 focus:ring-red-400">
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        <template x-for="item in filteredItems" :key="item.id">
                            <button type="button" @click="selectItem(item)"
                                class="flex flex-col w-full px-5 py-3 text-left transition-colors border-b border-white/60 hover:bg-red-50/80"
                                :class="selectedItemId == item.id ? 'bg-red-50/80' : ''">
                                <span class="text-sm font-medium text-gray-800" x-text="item.kode_designator + ' — ' + item.uraian_pekerjaan"></span>
                                <span class="text-xs text-gray-500" x-text="(item.kategori_pekerjaan || 'Tanpa kategori') + ' · ' + item.satuan"></span>
                            </button>
                        </template>
                        <p x-show="filteredItems.length === 0" class="px-5 py-6 text-sm text-center text-gray-400">Tidak ada item yang cocok.</p>
                    </div>
                    <div class="p-3 text-right border-t border-white/60">
                        <button type="button" @click="itemModalOpen = false" class="px-3 py-1.5 text-sm rounded-lg border border-gray-300 hover:bg-white">Tutup</button>
                    </div>
                </div>
            </div>
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
            <button type="submit" :disabled="loading"
              class="inline-flex items-center gap-2 px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed">
              <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              <span x-text="loading ? 'Menyimpan...' : 'Simpan & Lanjut Upload Foto'"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>