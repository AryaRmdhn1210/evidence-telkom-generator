<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Buat Proyek Baru
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('proyek.store') }}">
          @csrf
          @include('proyek.form')

          <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('proyek.index') }}" class="px-4 py-2 rounded border">Batal</a>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
              Simpan & Lanjut Input Item
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>