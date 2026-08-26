<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Upload Foto — {{ $itemProyek->itemPekerjaan->uraian_pekerjaan }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

      @if (session('status'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
        {{ $errors->first() }}
      </div>
      @endif

      <div class="bg-white shadow rounded p-6">
        <p class="text-sm text-gray-600 mb-1">
          STO: {{ $proyek->sto }} &middot; Kategori: {{ $itemProyek->kategori_foto === 'representatif' ? 'Representatif' : 'Wajib per unit' }}
        </p>
        <p class="font-medium mb-4">
          {{ $itemProyek->fotoBukti->count() }} / {{ $itemProyek->jumlah_foto_wajib }} foto terupload
        </p>

        <div class="grid grid-cols-4 gap-3 mb-6">
          @foreach ($itemProyek->fotoBukti as $foto)
          <div class="relative group">
            <img src="{{ asset('storage/' . $foto->file_path) }}" class="aspect-square object-cover rounded w-full">
            <form action="{{ route('proyek.item.foto.destroy', [$proyek, $itemProyek, $foto]) }}" method="POST"
              class="absolute top-1 right-1"
              onsubmit="return confirm('Hapus foto ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-600 text-white text-xs w-5 h-5 rounded-full leading-none">×</button>
            </form>
          </div>
          @endforeach

          @for ($i = 0; $i < ($itemProyek->jumlah_foto_wajib - $itemProyek->fotoBukti->count()); $i++)
            <div class="aspect-square border-2 border-dashed border-gray-300 rounded flex items-center justify-center text-gray-400 text-xs">
              kosong
            </div>
            @endfor
        </div>

        @if ($itemProyek->status_lengkap)
        <div class="p-3 bg-green-100 text-green-700 rounded text-sm mb-4">
          Semua foto sudah lengkap.
        </div>
        @else
        <form action="{{ route('proyek.item.upload.store', [$proyek, $itemProyek]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Upload foto (bisa pilih banyak sekaligus)
          </label>
          <input type="file" name="foto[]" multiple accept="image/*" class="block w-full mb-4">
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Upload
          </button>
        </form>
        @endif

        <div class="mt-6 flex justify-between">
          <a href="{{ route('proyek.show', $proyek) }}" class="text-sm text-gray-600 hover:underline">← Kembali ke Proyek</a>
          @if ($itemProyek->status_lengkap)
          <a href="{{ route('proyek.item.create', $proyek) }}" class="text-sm text-red-600 hover:underline">+ Tambah Item Lain</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>