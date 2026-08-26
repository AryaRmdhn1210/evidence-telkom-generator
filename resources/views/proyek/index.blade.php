<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Daftar Proyek
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

      @if (session('status'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('status') }}
      </div>
      @endif

      <div class="flex justify-end mb-4">
        <a href="{{ route('proyek.create') }}"
          class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
          + Buat Proyek Baru
        </a>
      </div>

      <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm text-left">
          <thead class="bg-gray-50 text-gray-600">
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
                <a href="{{ route('proyek.show', $proyek) }}" class="text-indigo-600 hover:underline font-medium">
                  {{ $proyek->nama_proyek }}
                </a>
              </td>
              <td class="px-4 py-3">{{ $proyek->witel }} / {{ $proyek->lokasi }}</td>
              <td class="px-4 py-3">{{ $proyek->sto }}</td>
              <td class="px-4 py-3">{{ $proyek->pembuat->name ?? '-' }}</td>
              <td class="px-4 py-3 space-x-2">
                <a href="{{ route('proyek.edit', $proyek) }}" class="text-indigo-600 hover:underline">Edit</a>
                <form action="{{ route('proyek.destroy', $proyek) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin hapus proyek ini? Semua item dan foto di dalamnya juga akan terhapus.')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                Belum ada proyek. Klik "Buat Proyek Baru" untuk mulai.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $proyeks->links() }}
      </div>
    </div>
  </div>
</x-app-layout>