<?php

namespace App\Http\Controllers;

use App\Models\FotoBukti;
use App\Models\ItemPekerjaan;
use App\Models\ItemProyek;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemProyekController extends Controller
{
  public function create(Proyek $proyek)
  {
    $itemPekerjaans = ItemPekerjaan::orderBy('uraian_pekerjaan')->get();

    return view('proyek.item.create', compact('proyek', 'itemPekerjaans'));
  }

  public function store(Request $request, Proyek $proyek)
  {
    $validated = $request->validate([
      'mode' => ['required', 'in:existing,baru'],
      'item_pekerjaan_id' => ['required_if:mode,existing', 'nullable', 'exists:item_pekerjaan,id'],
      'kode_designator' => ['required_if:mode,baru', 'nullable', 'string', 'max:255'],
      'uraian_pekerjaan' => ['required_if:mode,baru', 'nullable', 'string', 'max:255'],
      'satuan' => ['required_if:mode,baru', 'nullable', 'string', 'max:50'],
      'qty_drm' => ['required', 'integer', 'min:0'],
      'qty_rekon_aktual' => ['required', 'integer', 'min:0'],
      'qty_tambah' => ['required', 'integer', 'min:0'],
      'qty_kurang' => ['required', 'integer', 'min:0'],
      'kategori_foto' => ['required', 'in:representatif,wajib_per_unit'],
    ]);

    if ($validated['mode'] === 'baru') {
      $itemPekerjaan = ItemPekerjaan::create([
        'kode_designator' => $validated['kode_designator'],
        'uraian_pekerjaan' => $validated['uraian_pekerjaan'],
        'satuan' => $validated['satuan'],
        'is_master' => false,
      ]);
      $itemPekerjaanId = $itemPekerjaan->id;
    } else {
      $itemPekerjaanId = $validated['item_pekerjaan_id'];
    }

    $urutan = $proyek->itemProyek()->count() + 1;

    $itemProyek = $proyek->itemProyek()->create([
      'item_pekerjaan_id' => $itemPekerjaanId,
      'qty_drm' => $validated['qty_drm'],
      'qty_rekon_aktual' => $validated['qty_rekon_aktual'],
      'qty_tambah' => $validated['qty_tambah'],
      'qty_kurang' => $validated['qty_kurang'],
      'kategori_foto' => $validated['kategori_foto'],
      'urutan_item' => $urutan,
    ]);

    return redirect()->route('proyek.item.upload', [$proyek, $itemProyek])
      ->with('status', 'Item berhasil ditambahkan. Sekarang upload foto buktinya.');
  }

  public function upload(Proyek $proyek, ItemProyek $itemProyek)
  {
    $itemProyek->load('itemPekerjaan', 'fotoBukti');

    return view('proyek.item.upload', compact('proyek', 'itemProyek'));
  }

  public function storeFoto(Request $request, Proyek $proyek, ItemProyek $itemProyek)
  {
    $request->validate([
      'foto' => ['required', 'array'],
      'foto.*' => ['image', 'max:5120'],
    ]);

    $sisaSlot = $itemProyek->jumlah_foto_wajib - $itemProyek->fotoBukti()->count();
    $fotoBaru = array_slice($request->file('foto'), 0, max($sisaSlot, 0));

    $nomorUrut = $itemProyek->fotoBukti()->max('nomor_urut') ?? 0;

    foreach ($fotoBaru as $file) {
      $path = $file->store('foto-bukti/' . $proyek->id . '/' . $itemProyek->id, 'public');
      $nomorUrut++;

      FotoBukti::create([
        'item_proyek_id' => $itemProyek->id,
        'file_path' => $path,
        'nomor_urut' => $nomorUrut,
      ]);
    }

    return redirect()->route('proyek.item.upload', [$proyek, $itemProyek])
      ->with('status', 'Foto berhasil diupload.');
  }

  public function destroyFoto(Proyek $proyek, ItemProyek $itemProyek, FotoBukti $foto)
  {
    Storage::disk('public')->delete($foto->file_path);
    $foto->delete();

    return back()->with('status', 'Foto berhasil dihapus.');
  }

  public function destroy(Proyek $proyek, ItemProyek $itemProyek)
  {
    foreach ($itemProyek->fotoBukti as $foto) {
      Storage::disk('public')->delete($foto->file_path);
    }

    $itemProyek->delete();

    return redirect()->route('proyek.show', $proyek)
      ->with('status', 'Item berhasil dihapus.');
  }
}
