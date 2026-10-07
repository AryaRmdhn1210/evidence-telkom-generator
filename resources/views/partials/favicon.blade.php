@php
// Pakai favicon.png (ikon persegi) kalau sudah ada, kalau belum pakai logo yang sekarang
$faviconFile = file_exists(public_path('images/favicon.png'))
? 'images/favicon.png'
: 'images/Logo-telkom-akses.jpg';
@endphp
<link rel="icon" href="{{ asset($faviconFile) }}?v=1">