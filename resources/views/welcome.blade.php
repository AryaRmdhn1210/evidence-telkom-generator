<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evidence Telkom Generator | PT Telkom Akses Banjarmasin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
$logo = asset('images/Logo-telkom-akses.jpg');

$statistik = [
['angka' => '5', 'label' => 'Langkah alur kerja', 'ket' => 'Dari buat proyek sampai laporan jadi.'],
['angka' => '2 Format', 'label' => 'Laporan otomatis', 'ket' => 'Dapat diunduh sebagai PDF dan Word.'],
['angka' => '2 Peran', 'label' => 'Admin dan Karyawan', 'ket' => 'Akses disesuaikan dengan tanggung jawab.'],
];

$alur = [
['judul' => 'Buat Proyek', 'isi' => 'Isi header laporan: nama proyek, kontrak, surat pesanan, witel, lokasi, STO, dan pelaksana.', 'icon' => 'M12 4v16m8-8H4'],
['judul' => 'Input Item', 'isi' => 'Pilih item dari katalog, isi quantity, lalu tentukan kategori foto.', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
['judul' => 'Upload Foto', 'isi' => 'Unggah foto bukti kerja sesuai jumlah slot yang diminta.', 'icon' => 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12'],
['judul' => 'Review', 'isi' => 'Pastikan semua item sudah lengkap fotonya sebelum laporan dibuat.', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
['judul' => 'Generate', 'isi' => 'Pilih tanggal uji terima, lalu unduh laporan PDF atau Word.', 'icon' => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
];

$fitur = [
['judul' => 'Katalog Item Terpusat', 'isi' => 'Admin mengelola daftar designator dan uraian pekerjaan. Item di luar katalog tetap bisa ditambah manual saat input.', 'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'],
['judul' => 'Recheck Quantity Otomatis', 'isi' => 'DRM ditambah tambah dikurangi kurang dibandingkan dengan rekon atau aktual sebagai informasi, tanpa memblokir penyimpanan.', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
['judul' => 'Foto Sesuai Kategori', 'isi' => 'Representatif cukup 1 foto, wajib per unit sejumlah quantity aktual. Jumlah slot upload menyesuaikan otomatis.', 'icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z'],
['judul' => 'Keterangan Foto Otomatis', 'isi' => 'STO, lokasi, item beserta nomor urut, dan mitra tercetak otomatis di setiap foto tanpa input manual.', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
['judul' => 'Review Kelengkapan', 'isi' => 'Ringkasan status foto tiap item sebelum laporan dibuat, supaya tidak ada yang terlewat.', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
['judul' => 'Laporan PDF dan Word', 'isi' => 'BOQ hasil uji terima dan halaman evidence tersusun otomatis, lengkap dengan kolom tanda tangan. Riwayat laporan tersimpan.', 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
];

$peran = [
['judul' => 'Admin', 'isi' => 'Mengelola akun pengguna dan katalog item, memantau aktivitas seluruh tim lewat dashboard, serta tetap dapat men-generate laporan meski foto belum lengkap.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
['judul' => 'Karyawan', 'isi' => 'Membuat proyek, menginput item, dan mengunggah foto evidence. Laporan dapat di-generate setelah semua foto lengkap.', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
];
@endphp

<body class="text-gray-900 bg-red-50/40"
    style="font-family: 'IBM Plex Sans', ui-sans-serif, system-ui, sans-serif;">

    <!-- Header: card memanjang kiri-kanan -->
    <header class="sticky top-0 z-50 border-b border-red-100 shadow-sm bg-white/90 backdrop-blur">
        <div class="flex items-center justify-between h-16 px-4 sm:px-8 lg:px-12">
            <div class="flex items-center gap-3">
                <img src="{{ $logo }}" alt="PT Telkom Akses" class="w-auto h-8 mix-blend-multiply">
                <span class="hidden w-px h-6 bg-gray-300 sm:block"></span>
                <span class="text-sm font-semibold text-gray-800 sm:text-base">Evidence Telkom Generator</span>
            </div>

            <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white transition rounded-full shadow bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700">
                Masuk
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="bg-gradient-to-br from-red-50 via-white to-red-50">
        <div class="grid items-center max-w-6xl gap-12 px-6 py-16 mx-auto md:grid-cols-2 md:py-24">
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 mb-6 text-xs font-semibold tracking-wide text-red-700 uppercase bg-red-100 rounded-full">
                    <span class="w-2 h-2 bg-red-600 rounded-full"></span> Banjarmasin, Kalimantan Selatan
                </span>
                <h1 class="mb-6 text-4xl font-extrabold leading-tight md:text-5xl">
                    Bukti kerja lapangan,
                    <span class="text-red-600">tercatat rapi</span>
                    dari hari pertama.
                </h1>
                <p class="mb-8 leading-relaxed text-gray-600">
                    Sistem generator laporan BAUT (Berita Acara Uji Terima) PT Telkom Akses Banjarmasin,
                    satu portal untuk pencatatan item pekerjaan, upload foto evidence, dan
                    pembuatan laporan hasil pekerjaan jaringan fiber di lapangan.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition rounded-lg shadow-lg bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700">
                        Masuk ke Portal
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="#tentang"
                        class="px-6 py-3 font-semibold text-red-700 transition bg-white border border-red-200 rounded-lg hover:bg-red-50">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Bulatan logo + teks lurus di bawahnya -->
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center border-2 border-red-200 border-dashed rounded-full w-72 h-72 md:w-80 md:h-80 bg-red-100/60">
                    <div class="flex items-center justify-center w-56 h-56 bg-white rounded-full shadow-lg md:w-64 md:h-64">
                        <img src="{{ $logo }}" alt="PT Telkom Akses" class="w-40 h-auto md:w-44 mix-blend-multiply">
                    </div>
                </div>
                <p class="mt-6 text-lg font-bold text-gray-800">Evidence Telkom Generator</p>
                <p class="text-sm text-gray-500">PT Telkom Akses Banjarmasin</p>
            </div>
        </div>
    </section>

    <!-- Tentang sistem -->
    <section id="tentang" class="px-4 py-16 scroll-mt-20 sm:px-6">
        <div class="max-w-6xl p-6 mx-auto bg-white border border-red-100 shadow-sm rounded-3xl sm:p-10">
            <div class="max-w-2xl mx-auto mb-10 text-center">
                <p class="mb-2 text-xs font-bold tracking-widest text-red-600 uppercase">Tentang Sistem</p>
                <h2 class="mb-4 text-2xl font-bold md:text-3xl">Laporan BAUT yang tersusun rapi, tanpa kerja ulang di Excel dan Word.</h2>
                <p class="leading-relaxed text-gray-600">
                    Setiap pekerjaan lapangan perlu didokumentasikan lengkap dengan quantity dan foto buktinya.
                    Sistem ini menyatukan seluruh prosesnya dalam satu alur, lalu menyusun laporan akhir secara otomatis.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($statistik as $s)
                <div class="p-5 text-center border border-red-100 rounded-2xl bg-red-50/50">
                    <p class="text-3xl font-extrabold text-red-700">{{ $s['angka'] }}</p>
                    <p class="mt-1 font-semibold text-gray-800">{{ $s['label'] }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $s['ket'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Alur kerja -->
    <section id="alur" class="px-4 pb-16 scroll-mt-20 sm:px-6">
        <div class="max-w-6xl p-6 mx-auto bg-white border border-red-100 shadow-sm rounded-3xl sm:p-10">
            <div class="max-w-2xl mx-auto mb-10 text-center">
                <p class="mb-2 text-xs font-bold tracking-widest text-red-600 uppercase">Alur Kerja</p>
                <h2 class="mb-4 text-2xl font-bold md:text-3xl">Lima langkah dari proyek sampai laporan jadi.</h2>
                <p class="text-gray-600">Ikuti urutannya, dan sistem yang menyusun sisanya.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach ($alur as $a)
                <div class="relative p-5 transition border border-red-100 rounded-2xl bg-red-50/50 hover:-translate-y-0.5 hover:shadow-md">
                    <span class="absolute text-xs font-bold text-red-300 top-4 right-4">0{{ $loop->iteration }}</span>
                    <span class="flex items-center justify-center mb-4 text-white bg-red-600 w-11 h-11 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $a['icon'] }}" />
                        </svg>
                    </span>
                    <h3 class="mb-1 font-semibold text-gray-900">{{ $a['judul'] }}</h3>
                    <p class="text-sm leading-relaxed text-gray-600">{{ $a['isi'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section id="fitur" class="px-4 pb-16 scroll-mt-20 sm:px-6">
        <div class="max-w-6xl p-6 mx-auto bg-white border border-red-100 shadow-sm rounded-3xl sm:p-10">
            <div class="max-w-2xl mx-auto mb-10 text-center">
                <p class="mb-2 text-xs font-bold tracking-widest text-red-600 uppercase">Fitur Utama</p>
                <h2 class="mb-4 text-2xl font-bold md:text-3xl">Dirancang agar pencatatan lebih cepat dan minim salah.</h2>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($fitur as $f)
                <div class="p-6 transition border border-red-100 rounded-2xl bg-red-50/50 hover:-translate-y-0.5 hover:shadow-md">
                    <span class="flex items-center justify-center mb-4 text-white bg-red-600 w-11 h-11 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}" />
                        </svg>
                    </span>
                    <h3 class="mb-1 font-semibold text-gray-900">{{ $f['judul'] }}</h3>
                    <p class="text-sm leading-relaxed text-gray-600">{{ $f['isi'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Peran -->
    <section class="px-4 py-16 bg-gradient-to-br from-red-900 via-red-700 to-red-600 sm:px-6">
        <div class="max-w-4xl p-6 mx-auto border rounded-3xl bg-white/10 border-white/20 sm:p-10">
            <div class="max-w-xl mx-auto mb-10 text-center text-white">
                <p class="mb-2 text-xs font-bold tracking-widest uppercase text-white/70">Dua Peran, Satu Alur Kerja</p>
                <h2 class="mb-3 text-2xl font-bold md:text-3xl">Tampilan sesuai tanggung jawab.</h2>
                <p class="text-white/80">Setiap peran hanya melihat menu yang relevan dengan tugasnya.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($peran as $p)
                <div class="p-6 text-white border rounded-2xl bg-white/10 border-white/20">
                    <span class="flex items-center justify-center mb-4 text-red-600 bg-white w-11 h-11 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $p['icon'] }}" />
                        </svg>
                    </span>
                    <h3 class="mb-1 text-lg font-semibold">{{ $p['judul'] }}</h3>
                    <p class="text-sm leading-relaxed text-white/80">{{ $p['isi'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Ajakan masuk -->
    <section class="px-6 py-20 text-center">
        <h2 class="mb-3 text-2xl font-bold md:text-3xl">Siap mencatat pekerjaan hari ini?</h2>
        <p class="mb-8 text-gray-600">Masuk dengan akun yang telah didaftarkan oleh admin untuk mulai menggunakan sistem.</p>
        <a href="{{ route('login') }}"
            class="inline-flex items-center gap-2 px-8 py-3 font-semibold text-white transition rounded-lg shadow-lg bg-gradient-to-r from-red-800 to-red-600 hover:from-red-900 hover:to-red-700">
            Masuk ke Portal
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </section>

    <footer class="px-6 py-8 text-xs text-center text-gray-400 bg-gray-900">
        <span class="font-semibold text-gray-200">PT Telkom Akses</span> Cabang Banjarmasin &nbsp;|&nbsp;
        Evidence Telkom Generator &copy; {{ date('Y') }}
    </footer>

</body>

</html>