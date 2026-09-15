<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ $proyek->nama_proyek }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-5xl mx-auto space-y-6 sm:px-6 lg:px-8">

      @if (session('status'))
      <div class="p-3 text-green-700 bg-green-100 rounded">{{ session('status') }}</div>
      @endif

      <div class="p-6 bg-white rounded shadow">
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

      <div class="flex items-center justify-between">
        <h3 class="font-semibold text-gray-700">Item Pekerjaan</h3>
        <a href="{{ route('proyek.item.create', $proyek) }}"
          class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
          + Tambah Item
        </a>
      </div>

      <div class="overflow-hidden bg-white rounded shadow">
        <table class="w-full text-sm text-left">
          <thead class="text-gray-600 bg-gray-50">
            <tr>
              <th class="px-4 py-3">Kode Designator</th>
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
              <td class="px-4 py-3 font-mono text-xs">{{ $item->katalogItem->kode_designator }}</td>
              <td class="px-4 py-3">{{ $item->katalogItem->uraian_pekerjaan }}</td>
              <td class="px-4 py-3">{{ $item->katalogItem->satuan }}</td>
              <td class="px-4 py-3">{{ $item->qty_rekon_aktual }}</td>
              <td class="px-4 py-3">
                <span class="text-xs px-2 py-1 rounded {{ $item->kategori_foto === 'representatif' ? 'bg-gray-100 text-gray-700' : 'bg-blue-100 text-blue-700' }}">
                  {{ $item->kategori_foto === 'representatif' ? 'Representatif' : 'Wajib per unit' }}
                </span>
              </td>
              <td class="px-4 py-3">
                @if ($item->status_lengkap)
                <span class="px-2 py-1 text-xs text-green-700 bg-green-100 rounded">
                  Lengkap ({{ $item->fotoBukti->count() }}/{{ $item->jumlah_foto_wajib }})
                </span>
                @else
                <span class="px-2 py-1 text-xs text-yellow-700 bg-yellow-100 rounded">
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
              <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                Belum ada item. Klik "+ Tambah Item" untuk mulai.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="flex justify-end">
        <a href="{{ route('proyek.review', $proyek) }}"
          class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
          Review Laporan →
        </a>
      </div>

    </div>
  </div>
</x-app-layout>