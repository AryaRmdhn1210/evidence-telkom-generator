<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Evidence Telkom Generator</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Transisi antar halaman (landing <-> login): elemen yang diberi view-transition-name
           bergeser dan berubah ukuran secara mulus. Di browser yang belum mendukung,
           aturan ini diabaikan dan halaman berpindah seperti biasa. */
        @view-transition {
            navigation: auto;
        }

        ::view-transition-group(brand-logo),
        ::view-transition-group(brand-name) {
            animation-duration: 0.6s;
            animation-timing-function: cubic-bezier(0.22, 1, 0.36, 1);
        }

        ::view-transition-old(root),
        ::view-transition-new(root) {
            animation-duration: 0.4s;
        }

        /* Animasi masuk di dalam halaman login */
        @keyframes masuk-naik {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes kartu-masuk {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes getar {

            10%,
            90% {
                transform: translateX(-1px);
            }

            20%,
            80% {
                transform: translateX(2px);
            }

            30%,
            50%,
            70% {
                transform: translateX(-4px);
            }

            40%,
            60% {
                transform: translateX(4px);
            }
        }

        @keyframes melayang {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-16px);
            }
        }

        .anim-masuk {
            opacity: 0;
            animation: masuk-naik 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            animation-delay: var(--d, 0ms);
        }

        .anim-kartu {
            opacity: 0;
            animation: kartu-masuk 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.15s forwards;
        }

        /* Setelah login gagal: kartu langsung tampil dan bergetar sebentar */
        .anim-getar {
            animation: getar 0.5s ease 0.1s;
        }

        .glow {
            animation: melayang 9s ease-in-out infinite;
        }

        /* Hormati pengaturan "kurangi gerakan" pada sistem operasi */
        @media (prefers-reduced-motion: reduce) {

            .anim-masuk,
            .anim-kartu {
                animation: none;
                opacity: 1;
            }

            .anim-getar,
            .glow {
                animation: none;
            }

            ::view-transition-group(*),
            ::view-transition-old(*),
            ::view-transition-new(*) {
                animation: none !important;
            }
        }
    </style>
</head>
@php
$bgUrl = asset('images/login-bg.jpg');
$logo = asset('images/Logo-telkom-akses.jpg');
// Animasi masuk hanya diputar saat halaman dibuka normal, bukan setiap kali login gagal
$masuk = $errors->any() ? '' : 'anim-masuk';
@endphp

<body class="relative min-h-screen overflow-x-hidden bg-gray-900"
    style="font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;">

    <!-- Latar foto buram dan lapisan gelap (tema lama tetap dipakai) -->
    <div class="fixed inset-0 scale-105 bg-center bg-cover"
        style="background-image: url('{{ $bgUrl }}'); filter: blur(2px);">
    </div>
    <div class="fixed inset-0 bg-black/55"></div>

    <!-- Cahaya merah dekoratif -->
    <div class="fixed rounded-full pointer-events-none w-96 h-96 -top-24 -left-24 bg-red-600/30 blur-3xl glow"></div>
    <div class="fixed rounded-full pointer-events-none w-80 h-80 -bottom-24 right-1/3 bg-red-600/20 blur-3xl glow" style="animation-delay: -4s;"></div>

    <div class="relative z-10 grid min-h-screen lg:grid-cols-2">

        <!-- Panel kiri: merek dan teks pengantar (disembunyikan di layar kecil) -->
        <section class="flex-col justify-between hidden p-12 text-white lg:flex xl:p-16">
            <!-- Logo dan nama sistem diberi nama transisi supaya bisa "morph" dari/ke halaman landing -->
            <div class="flex items-center gap-4">
                <img src="{{ $logo }}" alt="PT Telkom Akses" class="w-auto h-14 drop-shadow-lg"
                    style="view-transition-name: brand-logo;">
                <span class="w-px h-8 bg-white/40"></span>
                <span class="text-lg font-semibold" style="view-transition-name: brand-name;">Evidence Telkom Generator</span>
            </div>

            <div class="max-w-xl">
                <span class="{{ $masuk }} inline-flex items-center gap-2 px-3 py-1 mb-6 text-xs font-semibold tracking-wide uppercase border rounded-full bg-white/10 border-white/20 backdrop-blur"
                    style="--d: 100ms">
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span> Banjarmasin, Kalimantan Selatan
                </span>

                <h2 class="{{ $masuk }} mb-5 text-4xl font-extrabold leading-tight xl:text-5xl" style="--d: 200ms">
                    Dokumentasi pekerjaan, <span class="text-red-400">lebih rapi</span> dan terstruktur.
                </h2>

                <p class="{{ $masuk }} mb-8 leading-relaxed text-white" style="--d: 300ms">
                    Evidence Telkom Generator membantu pencatatan item pekerjaan, pengelolaan foto evidence,
                    hingga pembuatan laporan BAUT dalam satu alur kerja.
                </p>

                <ul class="{{ $masuk }} flex flex-wrap text-sm gap-x-6 gap-y-2" style="--d: 400ms">
                    <li class="flex items-center gap-2"><span class="w-2 h-2 bg-green-400 rounded-full"></span> Dokumentasi</li>
                    <li class="flex items-center gap-2"><span class="w-2 h-2 bg-red-400 rounded-full"></span> Evidence</li>
                    <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-300"></span> Laporan</li>
                </ul>
            </div>

            <p class="{{ $masuk }} text-xs text-white/90" style="--d: 500ms">
                &copy; {{ date('Y') }} PT Telkom Akses Banjarmasin
            </p>
        </section>

        <!-- Panel kanan: kartu login kaca -->
        <section class="relative flex flex-col items-center justify-center px-5 py-20 sm:px-10 lg:bg-black/20">
            <a href="{{ url('/') }}"
                class="absolute z-10 flex items-center gap-1.5 px-4 py-2 text-sm transition rounded-full top-6 right-6 bg-black/30 hover:bg-black/40 text-white/90 hover:text-white">
                &larr; Kembali
            </a>

            <!-- Merek versi layar kecil (panel kiri disembunyikan di sana).
                 Sengaja di luar kartu supaya tidak ikut animasi masuk kartu dan posisinya stabil untuk transisi. -->
            <div class="flex items-center justify-center gap-3 mb-6 text-white lg:hidden">
                <img src="{{ $logo }}" alt="PT Telkom Akses" class="w-auto h-12 drop-shadow-lg"
                    style="view-transition-name: brand-logo;">
                <span class="w-px h-7 bg-white/40"></span>
                <span class="text-sm font-semibold" style="view-transition-name: brand-name;">Evidence Telkom Generator</span>
            </div>

            <div class="{{ $errors->any() ? 'anim-getar' : 'anim-kartu' }} w-full max-w-md p-8 text-white border sm:p-10 bg-white/10 backdrop-blur-md border-white/20 rounded-3xl">

                <div class="mb-7">
                    <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold tracking-wide uppercase border rounded-full bg-white/10 border-white/20">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span> Login
                    </span>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight">Selamat Datang</h1>
                    <p class="mt-1 text-sm text-white/90">Silakan masuk untuk mengakses portal.</p>
                </div>

                @if ($errors->any())
                <div class="p-3 mb-4 text-sm border border-red-400 bg-red-500/20 rounded-xl">
                    {{ $errors->first() }}
                </div>
                @endif

                @if (session('status'))
                <div class="p-3 mb-4 text-sm border border-green-400 bg-green-500/20 rounded-xl">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true" @pageshow.window="loading = false">
                    @csrf

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-white">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 flex items-center text-gray-400 left-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username"
                                placeholder="Masukkan username"
                                class="w-full py-3 pr-4 text-gray-900 placeholder-gray-500 bg-white rounded-full pl-11 focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                    </div>

                    <!-- Password: selalu tersembunyi, tampil hanya setelah ikon mata ditekan -->
                    <div x-data="{ show: false }" @pageshow.window="show = false">
                        <label class="block mb-2 text-sm font-semibold text-white">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 flex items-center text-gray-400 left-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm6-2V7a6 6 0 10-12 0v2m-1 0h14a1 1 0 011 1v9a2 2 0 01-2 2H6a2 2 0 01-2-2v-9a1 1 0 011-1z" />
                                </svg>
                            </span>
                            <input type="password" :type="show ? 'text' : 'password'" name="password" required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="w-full py-3 text-gray-900 placeholder-gray-500 bg-white rounded-full pr-11 pl-11 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <button type="button" @click="show = !show"
                                :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                                :title="show ? 'Sembunyikan password' : 'Tampilkan password'"
                                class="absolute inset-y-0 flex items-center text-gray-500 right-4 hover:text-gray-700">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remember" class="text-red-600 rounded focus:ring-red-500">
                        Ingat saya
                    </label>

                    <button type="submit" :disabled="loading"
                        class="flex items-center justify-center w-full gap-2 py-3 font-semibold text-white transition rounded-full bg-gradient-to-r from-red-600 to-red-400 hover:from-red-700 hover:to-red-500 disabled:opacity-60 disabled:cursor-not-allowed">
                        <svg x-show="loading" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" style="transform: scaleX(-1); transform-origin: center;" />
                        </svg>
                        <span x-text="loading ? 'Memproses...' : 'Masuk ke Portal'"></span>
                    </button>
                </form>

                <p class="mt-6 text-xs text-center text-white/90">Akses terbatas untuk pengguna sistem</p>
            </div>

            <!-- Hak cipta versi layar kecil (di layar besar ada di panel kiri) -->
            <p class="mt-6 text-xs text-center text-white/90 lg:hidden">
                &copy; {{ date('Y') }} PT Telkom Akses Banjarmasin
            </p>
        </section>
    </div>

</body>

</html>