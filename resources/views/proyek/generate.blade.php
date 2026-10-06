<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Generate Laporan — {{ $proyek->nama_proyek }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto space-y-6 sm:px-6 lg:px-8">

      <x-step-indicator current="5" />

      <x-flash-message />

      <div class="p-6 bg-white rounded shadow">
        @if (!$semuaLengkap)
        @if (Auth::user()->role === 'admin')
        <div class="p-3 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded">
          Masih ada {{ $itemKurang }} item yang fotonya belum lengkap. Sebagai admin, laporan tetap bisa digenerate.
        </div>
        @else
        <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded">
          Masih ada {{ $itemKurang }} item yang fotonya belum lengkap. Lengkapi dulu sebelum generate laporan.
        </div>
        @endif
        @endif

        @if ($semuaLengkap || Auth::user()->role === 'admin')
        <form method="POST" action="{{ route('proyek.generate.store', $proyek) }}" x-data="{ loading: false }" @submit="loading = true">
          @csrf
          <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Uji Terima</label>
          <input type="date" name="tanggal_uji_terima" value="{{ old('tanggal_uji_terima', now()->format('Y-m-d')) }}"
            class="block w-full mb-1 border-gray-300 rounded">
          @error('tanggal_uji_terima') <p class="mb-2 text-sm text-red-600">{{ $message }}</p> @enderror

          <button type="submit" :disabled="loading"
            class="inline-flex items-center gap-2 px-4 py-2 mt-3 text-white bg-red-600 rounded hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed">
            <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span x-text="loading ? 'Memproses...' : 'Generate Laporan (PDF & Word)'"></span>
          </button>
        </form>
        @else
        <button type="button" disabled class="px-4 py-2 text-gray-500 bg-gray-300 rounded cursor-not-allowed">
          Generate Laporan (PDF & Word)
        </button>
        @endif
      </div>

      <div class="overflow-hidden bg-white rounded shadow">
        <div class="p-4 font-semibold text-gray-700 border-b">Riwayat Laporan</div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead class="text-gray-600 bg-gray-50">
              <tr>
                <th class="px-4 py-3">Tanggal Uji Terima</th>
                <th class="px-4 py-3">Dibuat Oleh</th>
                <th class="px-4 py-3">Digenerate Pada</th>
                <th class="px-4 py-3">Download</th>
                <th class="px-4 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($proyek->laporan as $lap)
              <tr class="border-t">
                <td class="px-4 py-3">{{ $lap->tanggal_uji_terima->format('d-m-Y') }}</td>
                <td class="px-4 py-3">{{ $lap->pembuat->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $lap->created_at->format('d-m-Y H:i') }}</td>
                <td class="px-4 py-3 space-x-2">
                  @if ($lap->file_pdf)
                  <a href="{{ asset('storage/' . $lap->file_pdf) }}" target="_blank" class="text-indigo-600 hover:underline">PDF</a>
                  @endif
                  @if ($lap->file_word)
                  <a href="{{ asset('storage/' . $lap->file_word) }}" class="text-indigo-600 hover:underline">Word</a>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <form action="{{ route('proyek.laporan.destroy', [$proyek, $lap]) }}" method="POST"
                    onsubmit="return confirm('Yakin hapus riwayat laporan ini beserta file PDF dan Word-nya?')">
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
                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum pernah generate laporan.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div>
        <a href="{{ route('proyek.review', $proyek) }}" class="text-sm text-gray-600 hover:underline">← Kembali ke Review</a>
      </div>

    </div>
  </div>
</x-app-layout>