@php
$labelStatus = [
'belum_ada_item' => ['label' => 'Belum ada item', 'kelas' => 'bg-gray-100 text-gray-700'],
'belum_lengkap' => ['label' => 'Foto belum lengkap', 'kelas' => 'bg-yellow-100 text-yellow-800'],
'siap_generate' => ['label' => 'Siap generate', 'kelas' => 'bg-green-100 text-green-700'],
'sudah_generate' => ['label' => 'Sudah digenerate', 'kelas' => 'bg-blue-100 text-blue-700'],
];
$warnaBar = [
'belum_lengkap' => 'bg-yellow-500',
'siap_generate' => 'bg-green-600',
'sudah_generate' => 'bg-blue-600',
];
@endphp
<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Daftar Proyek
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <x-flash-message />

      <div class="flex flex-col gap-3 mb-4 lg:flex-row lg:items-center lg:justify-between">
        <form method="GET" class="flex flex-wrap items-center flex-1 gap-3">
          <div class="flex items-center w-full gap-2 sm:w-auto">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama proyek, witel, lokasi, atau STO..."
              class="w-full text-sm border-gray-300 rounded sm:w-80">
            <button type="submit"
              class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
              Cari
            </button>
            @if ($search || $status)
            <a href="{{ route('proyek.index', ['per_page' => $perPage]) }}" class="text-sm text-gray-600 hover:underline">Reset</a>
            @endif
          </div>

          <select name="status" onchange="this.form.submit()" class="py-1.5 pl-3 pr-8 text-sm border-gray-300 rounded" aria-label="Filter status">
            <option value="">Semua status</option>
            @foreach ($labelStatus as $kode => $info)
            <option value="{{ $kode }}" @selected($status===$kode)>{{ $info['label'] }}</option>
            @endforeach
          </select>

          <x-per-page :current="$perPage" />
        </form>
        <a href="{{ route('proyek.create') }}"
          class="px-4 py-2 text-sm text-center text-white bg-red-600 rounded hover:bg-red-700">
          + Buat Proyek Baru
        </a>
      </div>

      <div class="overflow-hidden bg-white rounded shadow">
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead class="text-gray-600 bg-gray-50">
              <tr>
                <th class="px-4 py-3">Nama Proyek</th>
                <th class="px-4 py-3">Witel / Lokasi</th>
                <th class="px-4 py-3">STO</th>
                <th class="px-4 py-3">Progres Foto</th>
                <th class="px-4 py-3">Dibuat Oleh</th>
                <th class="px-4 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($proyeks as $proyek)
              @php
              $r = $proyek->ringkasanFoto();
              $info = $labelStatus[$r['status']];
              @endphp
              <tr class="border-t">
                <td class="px-4 py-3">
                  <a href="{{ route('proyek.show', $proyek) }}" class="font-medium text-blue-600 hover:underline">
                    {{ $proyek->nama_proyek }}
                  </a>
                </td>
                <td class="px-4 py-3">{{ $proyek->witel }} / {{ $proyek->lokasi }}</td>
                <td class="px-4 py-3">{{ $proyek->sto }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                  @if ($r['status'] !== 'belum_ada_item')
                  <div class="flex items-center gap-2 mb-1">
                    <div class="w-24 h-2 overflow-hidden bg-gray-200 rounded-full" role="progressbar"
                      aria-valuenow="{{ $r['persen'] }}" aria-valuemin="0" aria-valuemax="100">
                      <div class="h-2 rounded-full {{ $warnaBar[$r['status']] }}" style="width: {{ $r['persen'] }}%"></div>
                    </div>
                    <span class="text-xs text-gray-600">{{ $r['terunggah'] }}/{{ $r['wajib'] }} foto</span>
                  </div>
                  @endif
                  <span class="inline-block px-2 py-0.5 text-xs rounded {{ $info['kelas'] }}">{{ $info['label'] }}@if ($r['status'] === 'sudah_generate') · {{ $r['jumlah_laporan'] }} laporan @endif</span>
                  @if ($r['jumlah_laporan'] > 0 && $r['status'] !== 'sudah_generate')
                  <span class="block mt-1 text-xs text-gray-500">{{ $r['jumlah_laporan'] }} laporan sudah dibuat</span>
                  @endif
                </td>
                <td class="px-4 py-3">{{ $proyek->pembuat->name ?? '-' }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="flex items-center gap-4">
                    @can('update', $proyek)
                    <a href="{{ route('proyek.edit', $proyek) }}" class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                      Edit
                    </a>
                    <form action="{{ route('proyek.destroy', $proyek) }}" method="POST" class="inline"
                      data-confirm="Hapus proyek {{ $proyek->nama_proyek }}? Semua item dan foto di dalamnya juga akan terhapus. Tindakan ini tidak bisa dibatalkan."
                      data-confirm-title="Hapus Proyek"
                      data-confirm-button="Ya, hapus proyek">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                      </button>
                    </form>
                    @else
                    <a href="{{ route('proyek.show', $proyek) }}" class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                      Lihat
                    </a>
                    @endcan
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                  <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                  </svg>
                  <p class="mt-3 text-sm font-medium text-gray-600">
                    {{ ($search || $status) ? 'Tidak ada proyek yang cocok dengan pencarian atau filter' : 'Belum ada proyek' }}
                  </p>
                  @unless ($search || $status)
                  <p class="mt-1 text-sm text-gray-500">Klik "Buat Proyek Baru" untuk mulai mencatat proyek pertamamu.</p>
                  @endunless
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="flex flex-col items-center justify-between gap-3 mt-4 sm:flex-row">
        <p class="text-sm text-gray-600">
          @if ($proyeks->total() > 0)
          Menampilkan {{ $proyeks->firstItem() }}-{{ $proyeks->lastItem() }} dari {{ $proyeks->total() }} proyek
          @else
          Tidak ada data
          @endif
        </p>
        {{ $proyeks->links() }}
      </div>
    </div>
  </div>
</x-app-layout>