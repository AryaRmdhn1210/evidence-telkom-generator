@php
$flashes = [];
if (session('status')) {
  $flashes[] = ['tipe' => 'sukses', 'pesan' => session('status')];
}
if (session('error')) {
  $flashes[] = ['tipe' => 'error', 'pesan' => session('error')];
}
@endphp

@foreach ($flashes as $f)
@php $error = $f['tipe'] === 'error'; @endphp
<div
  role="alert"
  x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, {{ $error ? 7000 : 4000 }})" x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
  class="flex items-center w-full gap-3 px-4 py-3 mb-4 border border-l-4 rounded-lg shadow-sm {{ $error ? 'text-red-800 bg-red-50 border-red-200 border-l-red-600' : 'text-green-800 bg-green-100 border-green-200 border-l-green-500' }}">

  <span class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-white rounded-full {{ $error ? 'bg-red-600' : 'bg-green-600' }}">
    @if ($error)
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v5m0 3h.01" />
    </svg>
    @else
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
    </svg>
    @endif
  </span>

  <span class="flex-1 text-sm font-medium">
    {{ $f['pesan'] }}
  </span>

  <button
    type="button"
    @click="show = false"
    class="flex-shrink-0 {{ $error ? 'text-red-700 hover:text-red-900' : 'text-green-700 hover:text-green-900' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>
</div>
@endforeach