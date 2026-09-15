<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Upload Foto — {{ $itemProyek->katalogItem->uraian_pekerjaan }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

      @if (session('status'))
      <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
      <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded">
        {{ $errors->first() }}
      </div>
      @endif

      <div class="p-6 bg-white rounded shadow">
        <p class="mb-1 text-sm text-gray-600">
          STO: {{ $proyek->sto }} &middot; Kategori: {{ $itemProyek->kategori_foto === 'representatif' ? 'Representatif' : 'Wajib per unit' }}
        </p>
        <p class="mb-4 font-medium">
          {{ $itemProyek->fotoBukti->count() }} / {{ $itemProyek->jumlah_foto_wajib }} foto terupload
        </p>

        <div class="grid grid-cols-4 gap-3 mb-6">
          @foreach ($itemProyek->fotoBukti as $foto)
          <div class="relative group">
            <img src="{{ asset('storage/' . $foto->file_path) }}" class="object-cover w-full rounded aspect-square">
            <form action="{{ route('proyek.item.foto.destroy', [$proyek, $itemProyek, $foto]) }}" method="POST"
              class="absolute top-1 right-1"
              onsubmit="return confirm('Hapus foto ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="w-5 h-5 text-xs leading-none text-white bg-red-600 rounded-full">×</button>
            </form>
          </div>
          @endforeach

          @for ($i = 0; $i < ($itemProyek->jumlah_foto_wajib - $itemProyek->fotoBukti->count()); $i++)
            <div class="flex items-center justify-center text-xs text-gray-400 border-2 border-gray-300 border-dashed rounded aspect-square">
              kosong
            </div>
            @endfor
        </div>

        @if ($itemProyek->status_lengkap)
        <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded">
          Semua foto sudah lengkap.
        </div>
        @else
        <form action="{{ route('proyek.item.upload.store', [$proyek, $itemProyek]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <label class="block mb-2 text-sm font-medium text-gray-700">
            Upload foto (bisa pilih banyak sekaligus)
          </label>
          <input type="file" name="foto[]" multiple accept="image/*" class="block w-full mb-4">
          <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
            Upload
          </button>
        </form>
        @endif

        <div class="flex justify-between mt-6">
          <a href="{{ route('proyek.show', $proyek) }}" class="text-sm text-gray-600 hover:underline">← Kembali ke Proyek</a>
          @if ($itemProyek->status_lengkap)
          <a href="{{ route('proyek.item.create', $proyek) }}" class="text-sm text-red-600 hover:underline">+ Tambah Item Lain</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>