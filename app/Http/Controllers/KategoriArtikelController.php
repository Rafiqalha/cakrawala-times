<?php

namespace App\Http\Controllers;

use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class KategoriArtikelController extends Controller
{
    public function index()
    {
        $kategori = KategoriArtikel::all();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_artikel,nama_kategori',
        ]);

        KategoriArtikel::create($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriArtikel $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriArtikel $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => "required|string|max:100|unique:kategori_artikel,nama_kategori,{$kategori->id}",
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriArtikel $kategori)
    {
        if ($kategori->artikel()->count() > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki artikel terkait.');
        }

        $kategori->delete();
        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
