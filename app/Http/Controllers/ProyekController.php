<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyekRequest;
use App\Models\Proyek;

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
    $validated = $request->validated();
    $validated['dibuat_oleh'] = auth()->id();

    $proyek = Proyek::create($validated);

    return redirect()->route('proyek.index')
      ->with('status', 'Proyek "' . $proyek->nama_proyek . '" berhasil dibuat.');
  }

  public function edit(Proyek $proyek)
  {
    return view('proyek.edit', compact('proyek'));
  }

  public function update(ProyekRequest $request, Proyek $proyek)
  {
    $proyek->update($request->validated());

    return redirect()->route('proyek.index')
      ->with('status', 'Proyek berhasil diperbarui.');
  }

  public function destroy(Proyek $proyek)
  {
    $proyek->delete();

    return redirect()->route('proyek.index')
      ->with('status', 'Proyek berhasil dihapus.');
  }
}
