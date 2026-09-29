@props(['current' => 1])

@php
$steps = [
    1 => 'Buat Proyek',
    2 => 'Input Item',
    3 => 'Upload Foto',
    4 => 'Review',
    5 => 'Generate',
];
@endphp

<div class="flex items-center justify-between pb-2 mb-6 overflow-x-auto">
    @foreach ($steps as $num => $label)
        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold
                    {{ $num < $current ? 'bg-green-500 text-white' : ($num === $current ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-500') }}">
                    @if ($num < $current)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    @else
                        {{ $num }}
                    @endif
                </div>
                <span class="text-xs mt-1 whitespace-nowrap {{ $num === $current ? 'text-red-600 font-semibold' : 'text-gray-500' }}">{{ $label }}</span>
            </div>
            @if (!$loop->last)
                <div class="flex-1 h-0.5 mx-2 {{ $num < $current ? 'bg-green-500' : 'bg-gray-200' }}"></div>
            @endif
        </div>
    @endforeach
</div>