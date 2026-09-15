<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Review — {{ $proyek->nama_proyek }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-5xl mx-auto space-y-6 sm:px-6 lg:px-8">

      @if (session('status'))
      <div class="p-3 text-green-700 bg-green-100 rounded">{{ session('status') }}</div>
      @endif

      <div class="grid grid-cols-3 gap-4">
        <div class="p-4 text-center bg-white rounded shadow">
          <p class="text-2xl font-bold text-gray-800">{{ $totalItem }}</p>
          <p class="text-sm text-gray-500">Total Item</p>
        </div>
        <div class="p-4 text-center bg-white rounded shadow">
          <p class="text-2xl font-bold text-green-600">{{ $itemLengkap }}</p>
          <p class="text-sm text-gray-500">Lengkap</p>
        </div>
        <div class="p-4 text-center bg-white rounded shadow">
          <p class="text-2xl font-bold text-yellow-600">{{ $itemKurang }}</p>
          <p class="text-sm text-gray-500">Belum Lengkap</p>
        </div>
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
              <th class="px-4 py-3">Status Foto</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($proyek->itemProyek as $item)
            <tr class="border-t {{ $item->status_lengkap ? '' : 'bg-yellow-50' }}">
              <td class="px-4 py-3 font-mono text-xs">{{ $item->katalogItem->kode_designator }}</td>
              <td class="px-4 py-3">{{ $item->katalogItem->uraian_pekerjaan }}</td>
              <td class="px-4 py-3">{{ $item->katalogItem->satuan }}</td>
              <td class="px-4 py-3">{{ $item->qty_rekon_aktual }}</td>
              <td class="px-4 py-3">
                {{ $item->kategori_foto === 'representatif' ? 'Representatif' : 'Wajib per unit' }}
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
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                Belum ada item untuk direview.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="p-6 bg-white rounded shadow">
        @if (Auth::user()->role === 'admin')
        @if (!$semuaLengkap)
        <div class="p-3 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded">
          Masih ada {{ $itemKurang }} item yang fotonya belum lengkap. Sebagai admin, kamu tetap bisa generate laporan — item yang kurang akan ditandai khusus di laporan.
        </div>
        @endif
        <div class="flex justify-end">
          <a href="{{ route('proyek.generate', $proyek) }}"
            class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
            Generate Laporan →
          </a>
        </div>
        @else
        @if (!$semuaLengkap)
        <div class="p-3 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded">
          Masih ada {{ $itemKurang }} item yang fotonya belum lengkap. Lengkapi dulu semua foto sebelum bisa generate laporan.
        </div>
        <div class="flex justify-end">
          <button type="button" disabled
            class="px-4 py-2 text-gray-500 bg-gray-300 rounded cursor-not-allowed">
            Generate Laporan →
          </button>
        </div>
        @else
        <div class="flex justify-end">
          <a href="{{ route('proyek.generate', $proyek) }}"
            class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
            Generate Laporan →
          </a>
        </div>
        @endif
        @endif
      </div>

      <div>
        <a href="{{ route('proyek.show', $proyek) }}" class="text-sm text-gray-600 hover:underline">← Kembali ke Proyek</a>
      </div>

    </div>
  </div>
</x-app-layout>