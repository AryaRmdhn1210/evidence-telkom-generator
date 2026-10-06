<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex w-full min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200" x-data="{ sidebarOpen: false }">

        @include('layouts.sidebar')

        <div class="flex flex-col flex-1 w-full min-w-0">
            <div class="flex items-center justify-between px-4 py-3 shadow sm:hidden bg-white/70 backdrop-blur-xl">
                <button @click="sidebarOpen = true" class="text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <x-application-logo class="w-8 h-8 text-gray-800 fill-current" />
                <div></div>
            </div>

            @isset($header)
            <header class="shadow-sm bg-white/60 backdrop-blur-xl">
                <div class="px-4 py-6 mx-auto max-w-[1600px] sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <main class="flex-1 w-full">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>