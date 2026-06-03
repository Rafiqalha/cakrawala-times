<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with(['penulis', 'kategori'])->get();
        return view('artikel.index', compact('artikel'));
    }

    public function create()
    {
        $kategori = KategoriArtikel::all();
        return view('artikel.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'isi_artikel' => 'required|string',
            'id_kategori' => 'required|exists:kategori_artikel,id',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        $data = $validated;
        $data['id_penulis'] = Auth::user()->id;
        $data['tanggal']    = now()->timezone('Asia/Jakarta')->format('Y-m-d');

        if ($request->hasFile('gambar')) {
            $gambarName = uniqid('gambar_') . '.' . $request->gambar->extension();
            $request->gambar->storeAs('gambar', $gambarName, 'public');
            $data['gambar'] = $gambarName;
        }

        Artikel::create($data);

        return redirect()->route('artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Artikel $artikel)
    {
        $kategori = KategoriArtikel::all();
        return view('artikel.edit', compact('artikel', 'kategori'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'isi_artikel' => 'required|string',
            'id_kategori' => 'required|exists:kategori_artikel,id',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        $data = $validated;

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar) {
                Storage::disk('public')->delete('gambar/' . $artikel->gambar);
            }
            $gambarName = uniqid('gambar_') . '.' . $request->gambar->extension();
            $request->gambar->storeAs('gambar', $gambarName, 'public');
            $data['gambar'] = $gambarName;
        }

        $artikel->update($data);

        return redirect()->route('artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->gambar) {
            Storage::disk('public')->delete('gambar/' . $artikel->gambar);
        }

        $artikel->delete();
        return redirect()->route('artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
