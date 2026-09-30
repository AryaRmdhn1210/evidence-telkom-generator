<!-- Overlay untuk mobile -->
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/30 backdrop-blur-sm sm:hidden"></div>

<aside
    class="fixed inset-y-0 left-0 z-40 flex flex-col transition-transform duration-200 transform border-r shadow-xl sm:static w-72 bg-white/70 backdrop-blur-xl border-white/60 text-slate-700 sm:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <!-- Brand -->
    <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-200/70">
        <div class="flex items-center justify-center text-sm font-bold text-white bg-red-600 rounded-lg w-9 h-9">ET</div>
        <div>
            <p class="text-sm font-semibold leading-tight text-slate-800">Evidence Telkom</p>
            <p class="text-xs leading-tight text-slate-500">Generator</p>
        </div>
        <button @click="sidebarOpen = false" class="ml-auto sm:hidden text-slate-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- User & jam real-time -->
    <div class="px-6 py-4 border-b border-slate-200/70">
        <p class="text-sm font-medium text-slate-800">{{ Auth::user()->name }}</p>
        <p class="text-xs tracking-wide uppercase text-slate-500">{{ Auth::user()->role }}</p>

        <div class="mt-3" x-data="{
                now: new Date(),
                init() { setInterval(() => this.now = new Date(), 1000) },
                get time() {
                    return this.now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                },
                get date() {
                    return this.now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                }
            }">
            <p class="text-2xl font-bold text-slate-800 tabular-nums" x-text="time"></p>
            <p class="text-xs text-slate-500" x-text="date"></p>
        </div>
    </div>

    <!-- Navigasi -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white shadow' : 'text-slate-600 hover:bg-white/80' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('proyek.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('proyek.*') ? 'bg-red-600 text-white shadow' : 'text-slate-600 hover:bg-white/80' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
            </svg>
            Proyek
        </a>

        @if (Auth::user()->role === 'admin')
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-red-600 text-white shadow' : 'text-slate-600 hover:bg-white/80' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 00-4-4H7a4 4 0 00-4 4v2h14v-2z" />
            </svg>
            Kelola User
        </a>

        <a href="{{ route('admin.katalog.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.katalog.*') ? 'bg-red-600 text-white shadow' : 'text-slate-600 hover:bg-white/80' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Kelola Katalog Item
        </a>
        @endif

        <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('profile.edit') ? 'bg-red-600 text-white shadow' : 'text-slate-600 hover:bg-white/80' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Profile
        </a>
    </nav>

    <!-- Logout -->
    <div class="px-3 py-4 border-t border-slate-200/70">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full gap-3 px-3 py-2 text-sm font-medium transition-colors rounded-lg text-slate-600 hover:bg-white/80">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Log Out
            </button>
        </form>
    </div>
</aside>