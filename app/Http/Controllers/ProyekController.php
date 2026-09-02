<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyekRequest;
use App\Models\Proyek;
use Illuminate\Support\Facades\Storage;
use App\Services\LaporanGenerator;
use Illuminate\Http\Request;
use App\Models\Laporan;

class ProyekController extends Controller
{
  public function index()
  {
    $proyeks = Proyek::with('pembuat')
      ->latest()
      ->paginate(10);

    return view('proyek.index', compact('proyeks'));
  }

  public function show(Proyek $proyek)
  {
    $proyek->load(['itemProyek.itemPekerjaan', 'itemProyek.fotoBukti']);

    return view('proyek.show', compact('proyek'));
  }

  public function create()
  {
    return view('proyek.create');
  }

  public function store(ProyekRequest $request)
  {
    $validated = $request->safe()->except(['ttd_tim_uji_terima', 'ttd_pelaksana']);
    $validated['dibuat_oleh'] = auth()->id();

    $proyek = Proyek::create($validated);

    if ($request->hasFile('ttd_tim_uji_terima')) {
      $proyek->ttd_tim_uji_terima = $request->file('ttd_tim_uji_terima')
        ->store('tanda-tangan/' . $proyek->id, 'public');
    }

    if ($request->hasFile('ttd_pelaksana')) {
      $proyek->ttd_pelaksana = $request->file('ttd_pelaksana')
        ->store('tanda-tangan/' . $proyek->id, 'public');
    }

    $proyek->save();

    return redirect()->route('proyek.index')
      ->with('status', 'Proyek "' . $proyek->nama_proyek . '" berhasil dibuat.');
  }

  public function edit(Proyek $proyek)
  {
    return view('proyek.edit', compact('proyek'));
  }

  public function update(ProyekRequest $request, Proyek $proyek)
  {
    $validated = $request->safe()->except(['ttd_tim_uji_terima', 'ttd_pelaksana']);
    $proyek->fill($validated);

    if ($request->hasFile('ttd_tim_uji_terima')) {
      if ($proyek->ttd_tim_uji_terima) {
        Storage::disk('public')->delete($proyek->ttd_tim_uji_terima);
      }
      $proyek->ttd_tim_uji_terima = $request->file('ttd_tim_uji_terima')
        ->store('tanda-tangan/' . $proyek->id, 'public');
    }

    if ($request->hasFile('ttd_pelaksana')) {
      if ($proyek->ttd_pelaksana) {
        Storage::disk('public')->delete($proyek->ttd_pelaksana);
      }
      $proyek->ttd_pelaksana = $request->file('ttd_pelaksana')
        ->store('tanda-tangan/' . $proyek->id, 'public');
    }

    $proyek->save();

    return redirect()->route('proyek.index')
      ->with('status', 'Proyek berhasil diperbarui.');
  }

  public function destroy(Proyek $proyek)
  {
    $proyek->delete();

    return redirect()->route('proyek.index')
      ->with('status', 'Proyek berhasil dihapus.');
  }

  public function review(Proyek $proyek)
  {
    $proyek->load(['itemProyek.itemPekerjaan', 'itemProyek.fotoBukti']);

    $totalItem = $proyek->itemProyek->count();
    $itemLengkap = $proyek->itemProyek->where('status_lengkap', true)->count();
    $itemKurang = $totalItem - $itemLengkap;
    $semuaLengkap = $totalItem > 0 && $itemKurang === 0;

    return view('proyek.review', compact('proyek', 'totalItem', 'itemLengkap', 'itemKurang', 'semuaLengkap'));
  }

  public function generate(Proyek $proyek)
  {
    $proyek->load([
      'itemProyek.itemPekerjaan',
      'itemProyek.fotoBukti',
      'laporan' => fn($q) => $q->latest(),
      'laporan.pembuat',
    ]);

    $totalItem = $proyek->itemProyek->count();
    $itemKurang = $proyek->itemProyek->where('status_lengkap', false)->count();
    $semuaLengkap = $totalItem > 0 && $itemKurang === 0;

    return view('proyek.generate', compact('proyek', 'semuaLengkap', 'itemKurang'));
  }

  public function generateStore(Request $request, Proyek $proyek, LaporanGenerator $generator)
  {
    $proyek->loadMissing('itemProyek.fotoBukti');

    if (auth()->user()->role !== 'admin') {
      $adaBelumLengkap = $proyek->itemProyek->contains(fn($item) => !$item->status_lengkap);
      if ($adaBelumLengkap) {
        abort(403, 'Semua item harus lengkap fotonya sebelum generate laporan.');
      }
    }

    $validated = $request->validate([
      'tanggal_uji_terima' => ['required', 'date'],
    ]);

    $generator->generate($proyek, $validated['tanggal_uji_terima'], auth()->id());

    return redirect()->route('proyek.generate', $proyek)
      ->with('status', 'Laporan berhasil digenerate.');
  }

    public function destroyLaporan(Proyek $proyek, Laporan $laporan)
  {
    if ($laporan->proyek_id !== $proyek->id) {
      abort(404);
    }

    if ($laporan->file_pdf) {
      Storage::disk('public')->delete($laporan->file_pdf);
    }

    if ($laporan->file_word) {
      Storage::disk('public')->delete($laporan->file_word);
    }

    $laporan->delete();

    return redirect()->route('proyek.generate', $proyek)
      ->with('status', 'Riwayat laporan berhasil dihapus.');
  }
}
