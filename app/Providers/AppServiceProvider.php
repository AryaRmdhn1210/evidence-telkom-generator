<?php

namespace App\Providers;

use App\Models\Laporan;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Data aktivitas terbaru untuk sidebar (muncul di semua halaman)
        View::composer('layouts.sidebar', function ($view) {
            $user = Auth::user();

            if (!$user) {
                $view->with('sidebarAktivitas', collect());
                return;
            }

            $isAdmin = $user->role === 'admin';

            $proyekQuery = Proyek::query();
            $laporanQuery = Laporan::with('proyek');

            if (!$isAdmin) {
                $proyekQuery->where('dibuat_oleh', $user->id);
                $laporanQuery->where('dibuat_oleh', $user->id);
            }

            $aktivitasProyek = $proyekQuery->latest()->take(10)->get()->map(fn($p) => [
                'jenis' => 'proyek',
                'teks' => 'Proyek "' . $p->nama_proyek . '" dibuat',
                'waktu' => $p->created_at,
            ]);

            $aktivitasLaporan = $laporanQuery->latest()->take(10)->get()->map(fn($l) => [
                'jenis' => 'laporan',
                'teks' => 'Laporan untuk "' . ($l->proyek->nama_proyek ?? '-') . '" digenerate',
                'waktu' => $l->created_at,
            ]);

            $view->with(
                'sidebarAktivitas',
                $aktivitasProyek->concat($aktivitasLaporan)
                    ->sortByDesc('waktu')
                    ->take(10)
                    ->values()
            );
        });
    }
}
