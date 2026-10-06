<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-gray-500">Ringkasan aktivitas {{ $isAdmin ? 'seluruh tim' : 'kamu' }} di Evidence Telkom Generator.</p>
            </div>

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

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="p-6 bg-white shadow lg:col-span-2 rounded-xl">
                    <h3 class="mb-4 font-semibold text-gray-700">Laporan Digenerate per Bulan</h3>
                    <canvas id="chartLaporanBulanan" height="120"></canvas>
                </div>
                <div class="p-6 bg-white shadow rounded-xl">
                    <h3 class="mb-4 font-semibold text-gray-700">Status Kelengkapan Item</h3>
                    <canvas id="chartStatusItem"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 {{ $isAdmin ? 'lg:grid-cols-2' : '' }} gap-6">
                <div class="overflow-hidden bg-white shadow rounded-xl">
                    <div class="px-6 py-4 font-semibold text-gray-700 border-b">Aktivitas Terbaru</div>
                    <ul class="divide-y">
                        @forelse ($aktivitasTerbaru as $a)
                        <li class="flex items-start gap-3 px-6 py-3">
                            <span class="mt-1.5 w-2 h-2 rounded-full {{ $a['jenis'] === 'proyek' ? 'bg-blue-500' : 'bg-green-500' }}"></span>
                            <div>
                                <p class="text-sm text-gray-800">{{ $a['teks'] }}</p>
                                <p class="text-xs text-gray-400">{{ $a['waktu']->diffForHumans() }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="px-6 py-6 text-sm text-center text-gray-400">Belum ada aktivitas.</li>
                        @endforelse
                    </ul>
                </div>

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

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('chartLaporanBulanan'), {
                type: 'bar',
                data: {
                    labels: @json($bulanLabels),
                    datasets: [{
                        label: 'Laporan',
                        data: @json($bulanData),
                        backgroundColor: '#dc2626',
                        borderRadius: 6,
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            new Chart(document.getElementById('chartStatusItem'), {
                type: 'doughnut',
                data: {
                    labels: ['Lengkap', 'Belum Lengkap'],
                    datasets: [{
                        data: [{{ $itemLengkap }}, {{ $itemBelumLengkap }}],
                        backgroundColor: ['#16a34a', '#eab308'],
                    }]
                },
                options: {
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>