@if ($paginator->hasPages())
<nav role="navigation" aria-label="Navigasi halaman" class="flex flex-wrap items-center justify-center gap-1 text-sm">

    {{-- Sebelumnya --}}
    @if ($paginator->onFirstPage())
    <span aria-disabled="true" class="px-3 py-1.5 text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed select-none">&larr; Sebelumnya</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-1.5 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">&larr; Sebelumnya</a>
    @endif

    {{-- Nomor halaman (yang bukan halaman aktif disembunyikan di layar sempit) --}}
    @foreach ($elements as $element)
        @if (is_string($element))
        <span class="hidden px-2 text-gray-400 sm:inline">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page" class="px-3 py-1.5 font-semibold text-white bg-red-600 border border-red-600 rounded">{{ $page }}</span>
                @else
                <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}" class="hidden px-3 py-1.5 text-gray-700 bg-white border border-gray-300 rounded sm:inline hover:bg-gray-50">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Berikutnya --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-1.5 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">Berikutnya &rarr;</a>
    @else
    <span aria-disabled="true" class="px-3 py-1.5 text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed select-none">Berikutnya &rarr;</span>
    @endif

</nav>
@endif