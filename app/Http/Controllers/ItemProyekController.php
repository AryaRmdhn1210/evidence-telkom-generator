<?php

namespace App\Http\Controllers;

use App\Models\FotoBukti;
use App\Models\KatalogItem;
use App\Models\ItemProyek;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ItemProyekController extends Controller
{
  /**
   * Pastikan item yang diakses memang bagian dari proyek di URL,
   * supaya izin di satu proyek tidak bisa dipakai untuk mengubah item proyek lain.
   */
  protected function pastikanItemMilikProyek(Proyek $proyek, ItemProyek $itemProyek): void
  {
    abort_if((int) $itemProyek->proyek_id !== (int) $proyek->id, 404);
  }

  /** Pesan validasi form item dalam bahasa Indonesia */
  protected function pesanItem(): array
  {
    return [
      'required' => ':attribute wajib diisi.',
      'required_if' => ':attribute wajib diisi.',
      'integer' => ':attribute harus berupa angka bulat.',
      'min' => ':attribute tidak boleh kurang dari :min.',
      'max' => ':attribute maksimal :max karakter.',
      'unique' => ':attribute sudah dipakai.',
      'exists' => ':attribute tidak valid.',
      'in' => ':attribute tidak valid.',
    ];
  }

  protected function namaAtributItem(): array
  {
    return [
      'mode' => 'Mode input',
      'katalog_item_id' => 'Item pekerjaan',
      'kode_designator' => 'Kode designator',
      'kategori_pekerjaan' => 'Kategori pekerjaan',
      'uraian_pekerjaan' => 'Uraian pekerjaan',
      'satuan' => 'Satuan',
      'qty_drm' => 'Quantity DRM',
      'qty_rekon_aktual' => 'Quantity Rekon/Aktual',
      'qty_tambah' => 'Quantity Tambah',
      'qty_kurang' => 'Quantity Kurang',
      'kategori_foto' => 'Kategori foto',
    ];
  }

  public function create(Proyek $proyek)
  {
    Gate::authorize('update', $proyek);

    $katalogItems = KatalogItem::orderBy('uraian_pekerjaan')->get();

    return view('proyek.item.create', compact('proyek', 'katalogItems'));
  }

  public function store(Request $request, Proyek $proyek)
  {
    Gate::authorize('update', $proyek);

    $validated = $request->validate([
      'mode' => ['required', 'in:existing,baru'],
      'katalog_item_id' => ['required_if:mode,existing', 'nullable', 'exists:katalog_item,id'],
      'kode_designator' => ['required_if:mode,baru', 'nullable', 'string', 'max:255', 'unique:katalog_item,kode_designator'],
      'kategori_pekerjaan' => ['nullable', 'string', 'max:255'],
      'uraian_pekerjaan' => ['required_if:mode,baru', 'nullable', 'string', 'max:255'],
      'satuan' => ['required_if:mode,baru', 'nullable', 'string', 'max:50'],
      'qty_drm' => ['required', 'integer', 'min:0'],
      'qty_rekon_aktual' => ['required', 'integer', 'min:0'],
      'qty_tambah' => ['required', 'integer', 'min:0'],
      'qty_kurang' => ['required', 'integer', 'min:0'],
      'kategori_foto' => ['required', 'in:representatif,wajib_per_unit'],
    ], $this->pesanItem(), $this->namaAtributItem());

    if ($validated['mode'] === 'baru') {
      $katalogItem = KatalogItem::create([
        'kode_designator' => $validated['kode_designator'],
        'uraian_pekerjaan' => $validated['uraian_pekerjaan'],
        'kategori_pekerjaan' => $validated['kategori_pekerjaan'] ?? null,
        'satuan' => $validated['satuan'],
        'is_master' => false,
      ]);
      $katalogItemId = $katalogItem->id;
    } else {
      $katalogItemId = $validated['katalog_item_id'];
    }

    $urutan = $proyek->itemProyek()->count() + 1;

    $itemProyek = $proyek->itemProyek()->create([
      'katalog_item_id' => $katalogItemId,
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

  public function edit(Proyek $proyek, ItemProyek $itemProyek)
  {
    Gate::authorize('update', $proyek);
    $this->pastikanItemMilikProyek($proyek, $itemProyek);

    $katalogItems = KatalogItem::orderBy('uraian_pekerjaan')->get();
    $fotoAda = $itemProyek->fotoBukti()->count();

    return view('proyek.item.edit', compact('proyek', 'itemProyek', 'katalogItems', 'fotoAda'));
  }

  public function update(Request $request, Proyek $proyek, ItemProyek $itemProyek)
  {
    Gate::authorize('update', $proyek);
    $this->pastikanItemMilikProyek($proyek, $itemProyek);

    $validated = $request->validate([
      'katalog_item_id' => ['required', 'exists:katalog_item,id'],
      'qty_drm' => ['required', 'integer', 'min:0'],
      'qty_rekon_aktual' => ['required', 'integer', 'min:0'],
      'qty_tambah' => ['required', 'integer', 'min:0'],
      'qty_kurang' => ['required', 'integer', 'min:0'],
      'kategori_foto' => ['required', 'in:representatif,wajib_per_unit'],
    ], $this->pesanItem(), $this->namaAtributItem());

    // Jumlah foto wajib baru mengikuti kategori dan quantity yang baru.
    // Kalau foto yang sudah ada lebih banyak dari itu, perubahan ditolak supaya
    // pengguna sendiri yang memilih foto mana yang dihapus (tidak ada yang hilang otomatis).
    $wajibBaru = $validated['kategori_foto'] === 'representatif'
      ? 1
      : (int) $validated['qty_rekon_aktual'];
    $fotoAda = $itemProyek->fotoBukti()->count();

    if ($fotoAda > $wajibBaru) {
      $kelebihan = $fotoAda - $wajibBaru;

      return back()->withInput()->withErrors([
        'jumlah_foto' => 'Item ini sudah memiliki ' . $fotoAda . ' foto, sedangkan pengaturan baru hanya meminta '
          . $wajibBaru . ' foto. Hapus ' . $kelebihan . ' foto dulu di halaman upload foto, lalu ulangi perubahan ini.',
      ]);
    }

    $itemProyek->update($validated);

    return redirect()->route('proyek.show', $proyek)
      ->with('status', 'Item berhasil diperbarui.');
  }

  public function upload(Proyek $proyek, ItemProyek $itemProyek)
  {
    Gate::authorize('update', $proyek);
    $this->pastikanItemMilikProyek($proyek, $itemProyek);

    $itemProyek->load('katalogItem', 'fotoBukti');

    return view('proyek.item.upload', compact('proyek', 'itemProyek'));
  }

  public function storeFoto(Request $request, Proyek $proyek, ItemProyek $itemProyek)
  {
    Gate::authorize('update', $proyek);
    $this->pastikanItemMilikProyek($proyek, $itemProyek);

    $request->validate([
      'foto' => ['required', 'array', 'min:1'],
      'foto.*' => ['image', 'max:5120'],
    ], [
      'foto.required' => 'Pilih minimal satu foto untuk diupload.',
      'foto.array' => 'Data foto tidak valid. Coba pilih ulang fotonya.',
      'foto.min' => 'Pilih minimal satu foto untuk diupload.',
      'foto.*.image' => 'Foto ke-:position bukan file gambar yang valid (gunakan JPG, PNG, atau WEBP).',
      'foto.*.max' => 'Foto ke-:position melebihi batas ukuran 5 MB.',
      'foto.*.uploaded' => 'Foto ke-:position gagal diunggah. Ukurannya mungkin melebihi batas server, coba kurangi ukuran atau jumlah fotonya.',
    ]);

    $sisaSlot = max($itemProyek->jumlah_foto_wajib - $itemProyek->fotoBukti()->count(), 0);
    $files = $request->file('foto');

    // Seluruh unggahan ditolak kalau melebihi slot, supaya tidak ada foto yang dibuang diam-diam
    if (count($files) > $sisaSlot) {
      $pesan = $sisaSlot === 0
        ? 'Semua slot foto untuk item ini sudah terisi. Hapus foto lama dulu kalau ingin menggantinya.'
        : 'Kamu memilih ' . count($files) . ' foto, tetapi slot yang tersisa hanya ' . $sisaSlot . '. Kurangi pilihan fotonya lalu coba lagi.';

      return back()->withErrors(['foto' => $pesan]);
    }

    $nomorUrut = $itemProyek->fotoBukti()->max('nomor_urut') ?? 0;

    foreach ($files as $file) {
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
    Gate::authorize('update', $proyek);
    $this->pastikanItemMilikProyek($proyek, $itemProyek);

    if ((int) $foto->item_proyek_id !== (int) $itemProyek->id) {
      abort(404);
    }

    Storage::disk('public')->delete($foto->file_path);
    $foto->delete();

    return back()->with('status', 'Foto berhasil dihapus.');
  }

  public function destroy(Proyek $proyek, ItemProyek $itemProyek)
  {
    Gate::authorize('update', $proyek);
    $this->pastikanItemMilikProyek($proyek, $itemProyek);

    foreach ($itemProyek->fotoBukti as $foto) {
      Storage::disk('public')->delete($foto->file_path);
    }

    $itemProyek->delete();

    return redirect()->route('proyek.show', $proyek)
      ->with('status', 'Item berhasil dihapus.');
  }
}