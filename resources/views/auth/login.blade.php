<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Evidence Telkom Generator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
$bgUrl = asset('images/login-bg.jpg');
@endphp

<body class="relative min-h-screen flex items-center justify-center bg-gray-900">

    <div class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $bgUrl }}');">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <a href="{{ url('/') }}"
        class="absolute top-6 left-6 z-10 text-white/90 hover:text-white text-sm flex items-center gap-1">
        ← Kembali
    </a>

    <div class="relative z-10 w-full max-w-sm bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 text-white">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold">PORTAL LOGIN</h1>
            <p class="text-sm text-white/70">Evidence Telkom Generator</p>
        </div>

        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-500/20 border border-red-400 rounded text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('status'))
        <div class="mb-4 p-3 bg-green-500/20 border border-green-400 rounded text-sm">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username"
                    class="w-full rounded-lg bg-white/90 text-gray-900 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-lg bg-white/90 text-gray-900 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="rounded">
                Ingat saya
            </label>

            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 transition text-white font-medium py-2.5 rounded-lg">
                Login →
            </button>
        </form>

        <p class="text-center text-xs text-white/50 mt-6">
            &copy; {{ date('Y') }} PT Telkom Akses Banjarmasin
        </p>
    </div>

</body>

</html>