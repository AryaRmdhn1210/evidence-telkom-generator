import Alpine from 'alpinejs';

window.Alpine = Alpine;

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