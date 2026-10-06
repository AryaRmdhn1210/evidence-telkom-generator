import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();

// Animasi transisi halus antar halaman (fade-out sebelum pindah)
document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link) return;
    if (link.target === '_blank' || link.hasAttribute('download')) return;
    if (!link.href || link.href.startsWith('javascript:')) return;
    if (link.origin !== window.location.origin) return;
    if (link.getAttribute('href')?.startsWith('#')) return;

    const main = document.querySelector('main');
    if (!main) return;

    e.preventDefault();
    main.classList.add('page-fade-out');

    setTimeout(() => {
        window.location.href = link.href;
    }, 250);
});

// Saat user menekan tombol Back/Forward, browser memulihkan halaman dari cache
// dengan class fade-out masih menempel. Hapus class itu supaya konten tampil lagi.
window.addEventListener('pageshow', () => {
    document.querySelector('main')?.classList.remove('page-fade-out');
});

// Grafik dashboard: data dibaca dari atribut data-* pada elemen <canvas>
document.addEventListener('DOMContentLoaded', () => {
    const barCanvas = document.getElementById('chartLaporanBulanan');
    if (barCanvas) {
        new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: JSON.parse(barCanvas.dataset.labels),
                datasets: [{
                    label: 'Laporan',
                    data: JSON.parse(barCanvas.dataset.values),
                    backgroundColor: '#dc2626',
                    borderRadius: 6,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }

    const donutCanvas = document.getElementById('chartStatusItem');
    if (donutCanvas) {
        new Chart(donutCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Lengkap', 'Belum Lengkap'],
                datasets: [{
                    data: JSON.parse(donutCanvas.dataset.values),
                    backgroundColor: ['#16a34a', '#eab308'],
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
});