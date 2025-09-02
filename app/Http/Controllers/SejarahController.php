<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sejarah;
use Illuminate\Support\Facades\Storage;

class SejarahController extends Controller
{
    public function index()
    {
        $data = Sejarah::all();
        return response()->json(['sejarah' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('sejarah', 'public');
        }

        $sejarah = Sejarah::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $path,
        ]);

        return response()->json(['message' => 'Sejarah berhasil disimpan', 'data' => $sejarah]);
    }

    public function update(Request $request, $id)
    {
        $sejarah = Sejarah::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($sejarah->gambar) {
                Storage::disk('public')->delete($sejarah->gambar);
            }

            $path = $request->file('gambar')->store('sejarah', 'public');
            $sejarah->gambar = $path;
        }

        $sejarah->judul = $request->judul;
        $sejarah->isi = $request->isi;
        $sejarah->save();

        return response()->json(['message' => 'Sejarah berhasil diperbarui', 'data' => $sejarah]);
    }

    public function destroy($id)
    {
        $sejarah = Sejarah::findOrFail($id);

        // Hapus gambar dari storage
        if ($sejarah->gambar) {
            Storage::disk('public')->delete($sejarah->gambar);
        }

        $sejarah->delete();

        return response()->json(['message' => 'Sejarah berhasil dihapus']);
    }
    public function getPublik()
{
    $data = Sejarah::all();
    return response()->json($data);
}
public function show($id)
{
    return Sejarah::findOrFail($id);
}

}
