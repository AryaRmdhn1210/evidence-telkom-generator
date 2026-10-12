@props(['current' => 10, 'options' => [5, 10, 25, 50]])

<label class="flex items-center gap-2 text-sm text-gray-600">
    Tampilkan
    <select name="per_page" onchange="this.form.submit()" class="py-1.5 pl-3 pr-8 text-sm border-gray-300 rounded">
        @foreach ($options as $opsi)
        <option value="{{ $opsi }}" @selected((int) $current === $opsi)>{{ $opsi }}</option>
        @endforeach
    </select>
    per halaman
</label>