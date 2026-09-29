<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Buat Proyek Baru
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

      <x-step-indicator current="1" />

      <div class="p-6 bg-white rounded shadow">
        <form method="POST" action="{{ route('proyek.store') }}" enctype="multipart/form-data" x-data="{ loading: false }" @submit="loading = true">
          @csrf
          @include('proyek.form')

          <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('proyek.index') }}" class="px-4 py-2 border rounded">Batal</a>
            <button type="submit" :disabled="loading"
              class="inline-flex items-center gap-2 px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed">
              <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              <span x-text="loading ? 'Menyimpan...' : 'Simpan & Lanjut Input Item'"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>