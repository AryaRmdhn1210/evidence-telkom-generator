<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $proyek->nama_proyek }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

      @if (session('status'))
      <div class="p-3 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
      @endif

      <div class="bg-white shadow rounded p-6">
        <dl class="grid grid-cols-2 gap-4 text-sm">
          <div>
            <dt class="text-gray-500">No Kontrak</dt>
            <dd>{{ $proyek->no_kontrak ?: '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">No Surat Pesanan</dt>
            <dd>{{ $proyek->no_surat_pesanan ?: '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Witel / Lokasi</dt>
            <dd>{{ $proyek->witel }} / {{ $proyek->lokasi }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">STO</dt>
            <dd>{{ $proyek->sto ?: '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Pelaksana</dt>
            <dd>{{ $proyek->pelaksana }}</dd>
          </div>
        </dl>
      </div>

      <div class="flex justify-between items-center">
        <h3 class="font-semibold text-gray-700">Item Pekerjaan</h3>
        <a href="{{ route('proyek.item.create', $proyek) }}"
          class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
          + Tambah Item
        </a>
      </div>

      <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm text-left">
          <thead class="bg-gray-50 text-gray-600">
            <tr>
              <th class="px-4 py-3">Item</th>
              <th class="px-4 py-3">Satuan</th>
              <th class="px-4 py-3">Rekon/Aktual</th>
              <th class="px-4 py-3">Kategori</th>
              <th class="px-4 py-3">Foto</th>
              <th class="px-4 py-3">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($proyek->itemProyek as $item)
            <tr class="border-t">
              <td class="px-4 py-3">{{ $item->itemPekerjaan->uraian_pekerjaan }}</td>
              <td class="px-4 py-3">{{ $item->itemPekerjaan->satuan }}</td>
              <td class="px-4 py-3">{{ $item->qty_rekon_aktual }}</td>
              <td class="px-4 py-3">
                <span class="text-xs px-2 py-1 rounded {{ $item->kategori_foto === 'representatif' ? 'bg-gray-100 text-gray-700' : 'bg-blue-100 text-blue-700' }}">
                  {{ $item->kategori_foto === 'representatif' ? 'Representatif' : 'Wajib per unit' }}
                </span>
              </td>
              <td class="px-4 py-3">
                @if ($item->status_lengkap)
                <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">
                  Lengkap ({{ $item->fotoBukti->count() }}/{{ $item->jumlah_foto_wajib }})
                </span>
                @else
                <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-700">
                  Kurang {{ $item->jumlah_foto_wajib - $item->fotoBukti->count() }} ({{ $item->fotoBukti->count() }}/{{ $item->jumlah_foto_wajib }})
                </span>
                @endif
              </td>
              <td class="px-4 py-3 space-x-2">
                <a href="{{ route('proyek.item.upload', [$proyek, $item]) }}" class="text-indigo-600 hover:underline">Upload Foto</a>
                <form action="{{ route('proyek.item.destroy', [$proyek, $item]) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin hapus item ini beserta semua fotonya?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                Belum ada item. Klik "+ Tambah Item" untuk mulai.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</x-app-layout>
