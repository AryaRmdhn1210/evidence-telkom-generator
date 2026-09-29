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
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead class="text-gray-600 bg-gray-50">
              <tr>
                <th class="px-4 py-3">Kode Designator</th>
                <th class="px-4 py-3">Uraian Pekerjaan</th>
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
                <td class="px-4 py-3 space-x-3">
                  <a href="{{ route('proyek.item.upload', [$proyek, $item]) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload Foto
                  </a>
                  <form action="{{ route('proyek.item.destroy', [$proyek, $item]) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin hapus item ini beserta semua fotonya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:underline">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                      Hapus
                    </button>
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