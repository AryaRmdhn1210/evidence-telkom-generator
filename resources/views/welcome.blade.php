<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evidence Telkom Generator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-linear-to-br from-red-50 via-white to-red-50 text-gray-900">

    <nav class="flex items-center justify-between px-8 py-5 max-w-7xl mx-auto">
        <div class="flex items-center gap-2 font-bold text-lg">
            <span class="text-red-600">●</span> Evidence Telkom Generator
        </div>
        <a href="{{ route('login') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full font-medium transition">
            Masuk →
        </a>
    </nav>

    <section class="max-w-7xl mx-auto px-8 py-16 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-flex items-center gap-2 bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full mb-6">
                <span class="w-2 h-2 bg-red-600 rounded-full"></span> BANJARMASIN, KALIMANTAN SELATAN
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                Bukti kerja lapangan,
                <span class="text-red-600">tercatat rapi</span>
                dari hari pertama.
            </h1>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Sistem generator laporan BAUT (Berita Acara Uji Terima) PT Telkom Akses
                Banjarmasin — satu portal untuk pencatatan item pekerjaan, upload foto evidence,
                dan generate laporan hasil pekerjaan jaringan fiber di lapangan.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('login') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    Masuk ke Portal →
                </a>
                <a href="#tentang"
                    class="border border-gray-300 hover:bg-gray-50 px-6 py-3 rounded-lg font-medium transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="w-80 h-80 rounded-full bg-red-100/60 border-2 border-dashed border-red-200 flex items-center justify-center">
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-700">Evidence</p>
                    <p class="text-red-600 font-bold text-2xl">Telkom Generator</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="max-w-5xl mx-auto px-8 py-16 grid md:grid-cols-3 gap-8 text-center">
        <div>
            <p class="text-3xl font-bold text-red-600 mb-2">Input</p>
            <p class="text-sm text-gray-600">Catat item pekerjaan dan quantity langsung dari data BoQ proyek.</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-red-600 mb-2">Upload</p>
            <p class="text-sm text-gray-600">Unggah foto bukti kerja sesuai kategori dan jumlah yang dibutuhkan.</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-red-600 mb-2">Generate</p>
            <p class="text-sm text-gray-600">Laporan BAUT tersusun otomatis, siap diunduh sebagai PDF atau Word.</p>
        </div>
    </section>

    <footer class="text-center text-xs text-gray-400 py-8">
        &copy; {{ date('Y') }} PT Telkom Akses Banjarmasin — Evidence Telkom Generator
    </footer>

</body>

</html>