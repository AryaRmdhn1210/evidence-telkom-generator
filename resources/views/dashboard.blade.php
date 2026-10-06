<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    @php
    if ($isAdmin) {
    $pintasan = [
    ['label' => 'Daftar Proyek', 'href' => route('proyek.index'), 'warna' => 'bg-red-100 text-red-600', 'icon' => 'M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z'],
    ['label' => 'Buat Proyek Baru', 'href' => route('proyek.create'), 'warna' => 'bg-green-100 text-green-600', 'icon' => 'M12 4v16m8-8H4'],
    ['label' => 'Katalog Item', 'href' => route('admin.katalog.index'), 'warna' => 'bg-blue-100 text-blue-600', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ['label' => 'Kelola User', 'href' => route('admin.users.index'), 'warna' => 'bg-purple-100 text-purple-600', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 00-4-4H7a4 4 0 00-4 4v2h14v-2z'],
    ];
    } else {
    $pintasan = [
    ['label' => 'Daftar Proyek', 'href' => route('proyek.index'), 'warna' => 'bg-red-100 text-red-600', 'icon' => 'M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z'],
    ['label' => 'Buat Proyek Baru', 'href' => route('proyek.create'), 'warna' => 'bg-green-100 text-green-600', 'icon' => 'M12 4v16m8-8H4'],
    ['label' => 'Profil Saya', 'href' => route('profile.edit'), 'warna' => 'bg-blue-100 text-blue-600', 'icon' => 'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z'],
    ];
    }
    @endphp

    <div class="py-8" x-data="{ panduanOpen: false }" @keydown.escape.window="panduanOpen = false">
        <div class="w-full px-4 mx-auto space-y-6 max-w-[1600px] sm:px-6 lg:px-8">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-gray-500">Ringkasan aktivitas {{ $isAdmin ? 'seluruh tim' : 'kamu' }} di Evidence Telkom Generator.</p>
            </div>

            <!-- Card pintasan -->
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                @foreach ($pintasan as $p)
                <a href="{{ $p['href'] }}"
                    class="flex flex-col items-center gap-3 p-5 transition bg-white shadow rounded-xl hover:shadow-md hover:-translate-y-0.5">
                    <span class="flex items-center justify-center w-11 h-11 rounded-full {{ $p['warna'] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $p['icon'] }}" />
                        </svg>
                    </span>
                    <span class="text-sm font-medium text-gray-700">{{ $p['label'] }}</span>
                </a>
                @endforeach

                @unless ($isAdmin)
                <button type="button" @click="panduanOpen = true"
                    class="flex flex-col items-center gap-3 p-5 transition bg-white shadow rounded-xl hover:shadow-md hover:-translate-y-0.5">
                    <span class="flex items-center justify-center text-purple-600 bg-purple-100 rounded-full w-11 h-11">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <span class="text-sm font-medium text-gray-700">Panduan Alur</span>
                </button>
                @endunless
            </div>

            <!-- Kartu statistik -->
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                <div class="p-5 bg-white shadow rounded-xl">
                    <p class="text-sm text-gray-500">Total Proyek</p>
                    <p class="mt-1 text-3xl font-bold text-gray-800">{{ $totalProyek }}</p>
                </div>
                <div class="p-5 bg-white shadow rounded-xl">
                    <p class="text-sm text-gray-500">Total Laporan</p>
                    <p class="mt-1 text-3xl font-bold text-gray-800">{{ $totalLaporan }}</p>
                </div>
                <div class="p-5 bg-white shadow rounded-xl">
                    <p class="text-sm text-gray-500">Item Lengkap</p>
                    <p class="mt-1 text-3xl font-bold text-green-600">{{ $itemLengkap }}</p>
                </div>
                <div class="p-5 bg-white shadow rounded-xl">
                    <p class="text-sm text-gray-500">Item Belum Lengkap</p>
                    <p class="mt-1 text-3xl font-bold text-yellow-600">{{ $itemBelumLengkap }}</p>
                </div>
            </div>

            <!-- Grafik (data dikirim lewat atribut data-*, kode grafik ada di resources/js/app.js) -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="min-w-0 p-6 bg-white shadow lg:col-span-2 rounded-xl">
                    <h3 class="mb-4 font-semibold text-gray-700">Laporan Digenerate per Bulan</h3>
                    <canvas id="chartLaporanBulanan" height="120"
                        data-labels="{{ json_encode($bulanLabels) }}"
                        data-values="{{ json_encode($bulanData) }}"></canvas>
                </div>
                <div class="min-w-0 p-6 bg-white shadow rounded-xl">
                    <h3 class="mb-4 font-semibold text-gray-700">Status Kelengkapan Item</h3>
                    <canvas id="chartStatusItem"
                        data-values="{{ json_encode([$itemLengkap, $itemBelumLengkap]) }}"></canvas>
                </div>
            </div>

            <!-- Ranking user (khusus admin) -->
            @if ($isAdmin)
            <div class="overflow-hidden bg-white shadow rounded-xl">
                <div class="px-6 py-4 font-semibold text-gray-700 border-b">User Paling Aktif</div>
                <ul class="divide-y">
                    @forelse ($rankingUser as $r)
                    <li class="flex items-center justify-between px-6 py-3">
                        <span class="text-sm text-gray-800">{{ $r->pembuat->name ?? '-' }}</span>
                        <span class="text-sm font-semibold text-red-600">{{ $r->total }} laporan</span>
                    </li>
                    @empty
                    <li class="px-6 py-6 text-sm text-center text-gray-400">Belum ada data.</li>
                    @endforelse
                </ul>
            </div>
            @endif

        </div>

        <!-- Popup Panduan Alur (karyawan) -->
        @unless ($isAdmin)
        <div x-show="panduanOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="panduanOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/30 backdrop-blur-sm"
                @click="panduanOpen = false"></div>

            <div x-show="panduanOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md p-6 bg-white shadow-xl rounded-2xl">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Panduan Alur Kerja</h3>
                <ol class="space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3"><span class="flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-600 rounded-full shrink-0">1</span><span><strong>Buat Proyek</strong> — isi header laporan (nama, kontrak, surat pesanan, witel, lokasi, STO, pelaksana).</span></li>
                    <li class="flex gap-3"><span class="flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-600 rounded-full shrink-0">2</span><span><strong>Input Item</strong> — pilih item pekerjaan, isi quantity, dan pilih kategori foto.</span></li>
                    <li class="flex gap-3"><span class="flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-600 rounded-full shrink-0">3</span><span><strong>Upload Foto</strong> — unggah foto bukti sesuai jumlah slot yang diminta.</span></li>
                    <li class="flex gap-3"><span class="flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-600 rounded-full shrink-0">4</span><span><strong>Review</strong> — pastikan semua item sudah lengkap fotonya.</span></li>
                    <li class="flex gap-3"><span class="flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-600 rounded-full shrink-0">5</span><span><strong>Generate</strong> — pilih tanggal uji terima, lalu unduh laporan PDF atau Word.</span></li>
                </ol>
                <div class="mt-6 text-right">
                    <button type="button" @click="panduanOpen = false"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">Tutup</button>
                </div>
            </div>
        </div>
        @endunless
    </div>
</x-app-layout>