<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Buat Proyek Baru
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="p-6 bg-white rounded shadow">
        <form method="POST" action="{{ route('proyek.store') }}" enctype="multipart/form-data">
          @csrf
          @include('proyek.form')

          <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('proyek.index') }}" class="px-4 py-2 border rounded">Batal</a>
            <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
              Simpan & Lanjut Input Item
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>