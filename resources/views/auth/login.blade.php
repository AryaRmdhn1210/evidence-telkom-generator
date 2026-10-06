<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Evidence Telkom Generator</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
$bgUrl = asset('images/login-bg.jpg');
@endphp

<body class="relative flex items-center justify-center min-h-screen bg-gray-900"
    style="font-family: 'IBM Plex Sans', ui-sans-serif, system-ui, sans-serif;">

    <div class="absolute inset-0 scale-105 bg-center bg-cover"
        style="background-image: url('{{ $bgUrl }}'); filter: blur(2px);">
    </div>
    <div class="absolute inset-0 bg-black/55"></div>

    <a href="{{ url('/') }}"
        class="absolute z-10 flex items-center gap-1.5 px-4 py-2 text-sm transition rounded-full top-6 left-6 bg-black/30 hover:bg-black/40 text-white/90 hover:text-white">
        &larr; Kembali
    </a>

    <div class="relative z-10 w-full max-w-md p-10 text-white border bg-white/10 backdrop-blur-md border-white/20 rounded-3xl">
        <div class="text-center mb-7">
            <img src="{{ asset('images/Logo-telkom-akses.jpg') }}" alt="PT Telkom Akses"
                class="w-auto mx-auto mb-5 h-9 drop-shadow">
            <h1 class="text-2xl font-bold tracking-tight">PORTAL LOGIN</h1>
            <p class="mt-1 text-sm text-white/70">Evidence Telkom Generator</p>
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

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
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
                        class="w-full py-3 pr-4 text-gray-900 placeholder-gray-400 bg-white rounded-full pl-11 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            </div>

            <div x-data="{ show: false }">
                <label class="block mb-2 text-sm font-semibold text-white">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 flex items-center text-gray-400 left-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm6-2V7a6 6 0 10-12 0v2m-1 0h14a1 1 0 011 1v9a2 2 0 01-2 2H6a2 2 0 01-2-2v-9a1 1 0 011-1z" />
                        </svg>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" required
                        placeholder="Masukkan password"
                        class="w-full py-3 text-gray-900 placeholder-gray-400 bg-white rounded-full pr-11 pl-11 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 flex items-center text-gray-400 right-4 hover:text-gray-600">
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

            <button type="submit"
                class="flex items-center justify-center w-full gap-2 py-3 font-semibold text-white transition rounded-full bg-gradient-to-r from-red-600 to-red-400 hover:from-red-700 hover:to-red-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" style="transform: scaleX(-1); transform-origin: center;" />
                </svg>
                Login
            </button>
        </form>

        <p class="text-xs text-center mt-7 text-white/50">
            &copy; {{ date('Y') }} PT Telkom Akses Banjarmasin
        </p>
    </div>

</body>

</html>