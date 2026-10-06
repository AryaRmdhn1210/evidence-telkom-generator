<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Daftar Proyek
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

      <x-flash-message />

      <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="flex-1 max-w-sm">
          <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama proyek, witel, lokasi, atau STO..."
            class="w-full text-sm border-gray-300 rounded" onchange="this.form.submit()">
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
                <th class="px-4 py-3">Dibuat Oleh</th>
                <th class="px-4 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($proyeks as $proyek)
              <tr class="border-t">
                <td class="px-4 py-3">
                  <a href="{{ route('proyek.show', $proyek) }}" class="font-medium text-indigo-600 hover:underline">
                    {{ $proyek->nama_proyek }}
                  </a>
                </td>
                <td class="px-4 py-3">{{ $proyek->witel }} / {{ $proyek->lokasi }}</td>
                <td class="px-4 py-3">{{ $proyek->sto }}</td>
                <td class="px-4 py-3">{{ $proyek->pembuat->name ?? '-' }}</td>
                <td class="px-4 py-3 space-x-3">
                  <a href="{{ route('proyek.edit', $proyek) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </a>
                  <form action="{{ route('proyek.destroy', $proyek) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin hapus proyek ini? Semua item dan foto di dalamnya juga akan terhapus.')">
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
                <td colspan="5" class="px-6 py-12 text-center">
                  <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                  </svg>
                  <p class="mt-3 text-sm font-medium text-gray-600">
                    {{ $search ? 'Tidak ada proyek yang cocok dengan pencarian' : 'Belum ada proyek' }}
                  </p>
                  @unless ($search)
                  <p class="mt-1 text-sm text-gray-400">Klik "Buat Proyek Baru" untuk mulai mencatat proyek pertamamu.</p>
                  @endunless
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-4">
        {{ $proyeks->links() }}
      </div>
    </div>
  </div>
</x-app-layout>