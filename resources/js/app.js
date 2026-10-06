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