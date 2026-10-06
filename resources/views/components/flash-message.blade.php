@if (session('status'))
<div
  x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
  class="flex items-center w-full gap-3 px-4 py-3 mb-4 text-green-800 bg-green-100 border border-l-4 border-green-200 rounded-lg shadow-sm border-l-green-500">
  <!-- Icon sukses -->
  <span
    class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-white bg-red-600 rounded-full">
    <svg
      class="w-4 h-4" fill="none"
      stroke="currentColor" viewBox="0 0 24 24">
      <path
        stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
    </svg>
  </span>

  <!-- Pesan -->
  <span class="flex-1 text-sm font-medium">
    {{ session('status') }}
  </span>

  <!-- Close -->
  <button
    type="button"
    @click="show = false"
    class="flex-shrink-0 text-green-700 hover:text-green-900">
    <svg
      class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path
        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>
</div>
@endif