<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Kelola Katalog Item
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
            <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">{{ session('status') }}</div>
            @endif
            @if (session('error'))
            <div class="p-3 mb-4 text-red-700 bg-red-100 rounded">{{ session('error') }}</div>
            @endif

            <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <form method="GET" class="flex-1 max-w-sm">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode, uraian, atau kategori..."
                        class="w-full text-sm border-gray-300 rounded" onchange="this.form.submit()">
                </form>
                <a href="{{ route('admin.katalog.create') }}"
                    class="px-4 py-2 text-sm text-center text-white bg-red-600 rounded hover:bg-red-700">
                    + Tambah Item Katalog
                </a>
            </div>

            <div class="overflow-hidden bg-white rounded shadow">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-600 bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Kode Designator</th>
                                <th class="px-4 py-3">Uraian Pekerjaan</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Satuan</th>
                                <th class="px-4 py-3">Dipakai di Proyek</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                            <tr class="border-t">
                                <td class="px-4 py-3 font-mono text-xs">{{ $item->kode_designator }}</td>
                                <td class="px-4 py-3">{{ $item->uraian_pekerjaan }}</td>
                                <td class="px-4 py-3">{{ $item->kategori_pekerjaan ?: '-' }}</td>
                                <td class="px-4 py-3">{{ $item->satuan }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs text-gray-700 bg-gray-100 rounded">
                                        {{ $item->item_proyek_count }}x
                                    </span>
                                </td>
                                <td class="px-4 py-3 space-x-3">
                                    <a href="{{ route('admin.katalog.edit', $item) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:underline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.katalog.destroy', $item) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin hapus item katalog ini?')">
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
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-3 text-sm font-medium text-gray-600">
                                        {{ $search ? 'Tidak ada item yang cocok dengan pencarian' : 'Belum ada item katalog' }}
                                    </p>
                                    @unless ($search)
                                    <p class="mt-1 text-sm text-gray-400">Klik "+ Tambah Item Katalog" untuk mulai.</p>
                                    @endunless
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>