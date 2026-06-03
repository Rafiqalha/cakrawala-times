<?php

namespace App\Http\Controllers;

use App\Models\Penulis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenulisController extends Controller
{
    public function index()
    {
        $penulis = Penulis::all();
        return view('penulis.index', compact('penulis'));
    }

    public function create()
    {
        return view('penulis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'user_name'    => 'required|string|max:50|unique:penulis,user_name',
            'password'     => 'required|string|min:6',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $data = $validated;
        $data['password'] = bcrypt($data['password']);

        if ($request->hasFile('foto')) {
            $fotoName = uniqid('foto_') . '.' . $request->foto->extension();
            $request->foto->storeAs('foto', $fotoName, 'public');
            $data['foto'] = $fotoName;
        }

        Penulis::create($data);

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function edit(Penulis $penulis)
    {
        return view('penulis.edit', compact('penulis'));
    }

    public function update(Request $request, Penulis $penulis)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'user_name'    => "required|string|max:50|unique:penulis,user_name,{$penulis->id}",
            'password'     => 'nullable|string|min:6',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $data = $validated;
        unset($data['password']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($penulis->foto && $penulis->foto !== 'default.png') {
                Storage::disk('public')->delete('foto/' . $penulis->foto);
            }
            $fotoName = uniqid('foto_') . '.' . $request->foto->extension();
            $request->foto->storeAs('foto', $fotoName, 'public');
            $data['foto'] = $fotoName;
        }

        $penulis->update($data);

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil diperbarui.');
    }

    public function destroy(Penulis $penulis)
    {
        if ($penulis->artikel()->count() > 0) {
            return redirect()->route('penulis.index')
                ->with('error', 'Penulis tidak dapat dihapus karena masih memiliki artikel.');
        }

        if ($penulis->foto && $penulis->foto !== 'default.png') {
            Storage::disk('public')->delete('foto/' . $penulis->foto);
        }

        $penulis->delete();
        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil dihapus.');
    }
}
