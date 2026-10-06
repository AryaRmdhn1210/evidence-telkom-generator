<?php

namespace App\Http\Controllers;

use App\Models\ItemProyek;
use App\Models\Laporan;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $isAdmin = $user->role === 'admin';

    $proyekQuery = Proyek::query();
    $laporanQuery = Laporan::query();

    if (!$isAdmin) {
      $proyekQuery->where('dibuat_oleh', $user->id);
      $laporanQuery->where('dibuat_oleh', $user->id);
    }

    $totalProyek = (clone $proyekQuery)->count();
    $totalLaporan = (clone $laporanQuery)->count();

    // Status kelengkapan item, scoped ke proyek milik user kalau karyawan
    $itemQuery = ItemProyek::query();
    if (!$isAdmin) {
      $itemQuery->whereHas('proyek', fn($q) => $q->where('dibuat_oleh', $user->id));
    }
    $itemProyekList = $itemQuery->with('fotoBukti')->get();
    $itemLengkap = $itemProyekList->where('status_lengkap', true)->count();
    $itemBelumLengkap = $itemProyekList->count() - $itemLengkap;

    // Grafik 1: jumlah laporan digenerate per bulan, 6 bulan terakhir
    $bulanLabels = [];
    $bulanData = [];
    for ($i = 5; $i >= 0; $i--) {
      $bulan = Carbon::now()->subMonths($i);
      $bulanLabels[] = $bulan->translatedFormat('M Y');
      $bulanData[] = (clone $laporanQuery)
        ->whereYear('created_at', $bulan->year)
        ->whereMonth('created_at', $bulan->month)
        ->count();
    }

    // Ranking user teraktif, khusus admin
    $rankingUser = [];
    if ($isAdmin) {
      $rankingUser = Laporan::selectRaw('dibuat_oleh, count(*) as total')
        ->groupBy('dibuat_oleh')
        ->with('pembuat')
        ->orderByDesc('total')
        ->take(5)
        ->get();
    }

    return view('dashboard', compact(
      'isAdmin',
      'totalProyek',
      'totalLaporan',
      'itemLengkap',
      'itemBelumLengkap',
      'bulanLabels',
      'bulanData',
      'rankingUser'
    ));
  }
}
