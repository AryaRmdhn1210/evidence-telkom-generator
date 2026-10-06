<!-- Overlay untuk mobile -->
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/30 backdrop-blur-sm sm:hidden"></div>

<aside
    class="fixed inset-y-0 left-0 z-40 flex flex-col text-white transition-transform duration-200 transform bg-red-600 shadow-xl sm:sticky sm:top-0 sm:h-screen w-72 sm:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <!-- Brand -->
    <div class="flex items-center gap-3 py-4 pl-6 pr-6 border-b border-white/20">
        <div class="flex items-center justify-center text-sm font-bold text-red-600 bg-white rounded-lg w-9 h-9">ET</div>
        <div>
            <p class="text-sm font-semibold leading-tight">Evidence Telkom</p>
            <p class="text-xs leading-tight text-white/70">Generator</p>
        </div>
        <button @click="sidebarOpen = false" class="ml-auto text-white/80 sm:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- User & jam real-time -->
    <div class="py-3 pl-6 pr-8 border-b border-white/20">
        <div class="flex items-center gap-2">
            <p class="text-base font-semibold leading-tight truncate">{{ Auth::user()->name }}</p>
            <span class="px-2 py-0.5 text-[11px] font-semibold tracking-wide uppercase rounded bg-white/20 shrink-0">{{ Auth::user()->role }}</span>
        </div>

        <div class="mt-2" x-data="{
                now: new Date(),
                init() { setInterval(() => this.now = new Date(), 1000) },
                get time() {
                    return this.now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                },
                get date() {
                    return this.now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                }
            }">
            <p class="text-3xl font-bold leading-none tabular-nums" x-text="time"></p>
            <p class="mt-1 text-sm text-white/80" x-text="date"></p>
        </div>
    </div>

    <!-- Navigasi -->
    <nav class="py-3 pl-3 pr-4 space-y-1">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-white text-red-600 shadow font-semibold' : 'text-white/90 hover:bg-white/15' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('proyek.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('proyek.*') ? 'bg-white text-red-600 shadow font-semibold' : 'text-white/90 hover:bg-white/15' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
            </svg>
            Proyek
        </a>

        @if (Auth::user()->role === 'admin')
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-white text-red-600 shadow font-semibold' : 'text-white/90 hover:bg-white/15' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 00-4-4H7a4 4 0 00-4 4v2h14v-2z" />
            </svg>
            Kelola User
        </a>

        <a href="{{ route('admin.katalog.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.katalog.*') ? 'bg-white text-red-600 shadow font-semibold' : 'text-white/90 hover:bg-white/15' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Kelola Katalog Item
        </a>
        @endif

        <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('profile.edit') ? 'bg-white text-red-600 shadow font-semibold' : 'text-white/90 hover:bg-white/15' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Profile
        </a>
    </nav>

    <!-- Aktivitas terbaru: mengisi seluruh sisa ruang antara Profile dan Log Out -->
    <div class="flex flex-col flex-1 min-h-[9rem] py-3 pl-3 pr-4 border-t border-white/20">
        <div class="flex flex-col flex-1 min-h-0 p-3 border rounded-xl bg-white/15 border-white/20">
            <p class="mb-2 text-xs font-semibold tracking-wider uppercase text-white/80">Aktivitas Terbaru</p>

            <!-- Isi memenuhi kotak; kalau lebih banyak dari ruang yang ada, bisa di-scroll -->
            <ul class="flex-1 min-h-0 pr-2 space-y-2 overflow-y-auto"
                style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.5) transparent;">
                @forelse ($sidebarAktivitas as $a)
                <li class="flex items-start gap-2">
                    <span class="mt-1.5 w-1.5 h-1.5 rounded-full shrink-0 {{ $a['jenis'] === 'proyek' ? 'bg-sky-300' : 'bg-green-300' }}"></span>
                    <div class="min-w-0">
                        <p class="text-xs leading-snug text-white line-clamp-2">{{ $a['teks'] }}</p>
                        <p class="text-[11px] text-white/70">{{ $a['waktu']->diffForHumans() }}</p>
                    </div>
                </li>
                @empty
                <li class="text-xs text-white/70">Belum ada aktivitas.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Logout -->
    <div class="py-3 pl-3 pr-4 border-t border-white/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full gap-3 px-3 py-2 text-sm font-medium transition-colors rounded-lg text-white/90 hover:bg-white/15">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Log Out
            </button>
        </form>
    </div>
</aside>