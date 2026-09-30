<?php

namespace App\Http\Controllers;

use App\Models\KatalogItem;
use Illuminate\Http\Request;

class KatalogItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $items = KatalogItem::when($search, function ($q) use ($search) {
                $q->where('kode_designator', 'like', "%{$search}%")
                  ->orWhere('uraian_pekerjaan', 'like', "%{$search}%")
                  ->orWhere('kategori_pekerjaan', 'like', "%{$search}%");
            })
            ->withCount('itemProyek')
            ->orderBy('kode_designator')
            ->paginate(15)
            ->withQueryString();

        return view('admin.katalog.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('admin.katalog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_designator' => ['required', 'string', 'max:255', 'unique:katalog_item,kode_designator'],
            'uraian_pekerjaan' => ['required', 'string', 'max:255'],
            'kategori_pekerjaan' => ['nullable', 'string', 'max:255'],
            'satuan' => ['required', 'string', 'max:50'],
        ]);

        KatalogItem::create($validated + ['is_master' => true]);

        return redirect()->route('admin.katalog.index')
            ->with('status', 'Item katalog berhasil ditambahkan.');
    }

    public function edit(KatalogItem $katalog)
    {
        return view('admin.katalog.edit', ['item' => $katalog]);
    }

    public function update(Request $request, KatalogItem $katalog)
    {
        $validated = $request->validate([
            'kode_designator' => ['required', 'string', 'max:255', 'unique:katalog_item,kode_designator,' . $katalog->id],
            'uraian_pekerjaan' => ['required', 'string', 'max:255'],
            'kategori_pekerjaan' => ['nullable', 'string', 'max:255'],
            'satuan' => ['required', 'string', 'max:50'],
        ]);

        $katalog->update($validated);

        return redirect()->route('admin.katalog.index')
            ->with('status', 'Item katalog berhasil diperbarui.');
    }

    public function destroy(KatalogItem $katalog)
    {
        if ($katalog->itemProyek()->exists()) {
            return back()->with('error', 'Item ini sudah dipakai di salah satu proyek, tidak bisa dihapus.');
        }

        $katalog->delete();

        return redirect()->route('admin.katalog.index')
            ->with('status', 'Item katalog berhasil dihapus.');
    }
}