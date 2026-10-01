<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Item Katalog
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded shadow">
                <form method="POST" action="{{ route('admin.katalog.update', $item) }}" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Kode Designator</label>
                        <input type="text" name="kode_designator" value="{{ old('kode_designator', $item->kode_designator) }}"
                            class="block w-full mt-1 border-gray-300 rounded">
                        @error('kode_designator') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Kategori Pekerjaan</label>
                        <input type="text" name="kategori_pekerjaan" value="{{ old('kategori_pekerjaan', $item->kategori_pekerjaan) }}"
                            class="block w-full mt-1 border-gray-300 rounded">
                        @error('kategori_pekerjaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Uraian Pekerjaan</label>
                        <input type="text" name="uraian_pekerjaan" value="{{ old('uraian_pekerjaan', $item->uraian_pekerjaan) }}"
                            class="block w-full mt-1 border-gray-300 rounded">
                        @error('uraian_pekerjaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Satuan</label>
                        <input type="text" name="satuan" value="{{ old('satuan', $item->satuan) }}"
                            class="block w-full mt-1 border-gray-300 rounded">
                        @error('satuan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    @if ($item->itemProyek()->exists())
                    <p class="mb-4 text-xs text-yellow-600">Item ini sudah dipakai di salah satu proyek. Mengubah data di sini tidak mengubah data yang sudah tercatat di proyek tersebut.</p>
                    @endif

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.katalog.index') }}" class="px-4 py-2 border rounded">Batal</a>
                        <button type="submit" :disabled="loading"
                            class="inline-flex items-center gap-2 px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span x-text="loading ? 'Menyimpan...' : 'Update'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>