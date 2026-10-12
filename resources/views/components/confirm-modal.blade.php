@php
// Kelas ditulis lengkap di sini supaya terdeteksi Tailwind
$tones = [
'danger' => ['icon' => 'bg-red-100 text-red-600', 'button' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500'],
'warning' => ['icon' => 'bg-amber-100 text-amber-600', 'button' => 'bg-amber-500 hover:bg-amber-600 focus:ring-amber-500'],
'success' => ['icon' => 'bg-green-100 text-green-600', 'button' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500'],
];
@endphp

<div x-data="confirmModal(@js($tones))"
  x-show="open" x-cloak
  @open-confirm.window="show($event.detail)"
  @keydown.escape.window="open && close()"
  class="fixed inset-0 z-[60] flex items-center justify-center p-4"
  role="dialog" aria-modal="true" aria-labelledby="confirm-modal-title">

  <div x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="absolute inset-0 bg-black/30 backdrop-blur-sm"
    @click="close()"></div>

  <div x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="relative w-full max-w-sm p-6 bg-white shadow-xl rounded-2xl">

    <div class="flex items-start gap-4">
      <span class="flex items-center justify-center rounded-full w-11 h-11 shrink-0" :class="warna.icon">
        <svg x-show="tone === 'danger'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        <svg x-show="tone === 'warning'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
        </svg>
        <svg x-show="tone === 'success'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </span>

      <div class="min-w-0">
        <h3 id="confirm-modal-title" class="text-lg font-semibold text-gray-800" x-text="title"></h3>
        <p class="mt-1 text-sm text-gray-600 break-words" x-text="message"></p>
      </div>
    </div>

    <div class="flex justify-end gap-2 mt-6">
      <button type="button" x-ref="batal" @click="close()"
        class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400">
        Batal
      </button>
      <button type="button" @click="confirm()" x-text="button"
        class="px-4 py-2 text-sm font-medium text-white rounded focus:outline-none focus:ring-2 focus:ring-offset-2"
        :class="warna.button"></button>
    </div>
  </div>
</div>