<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        return Galeri::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'tanggal_pelaksanaan' => 'required|date',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        return Galeri::create($data);
    }

    public function show($id)
    {
        return Galeri::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string',
            'tanggal_pelaksanaan' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $galeri->update($data);
        return $galeri;
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->delete();

        return response()->json(['message' => 'Data galeri berhasil dihapus']);
    }
    public function slider()
{
    $galeri = Galeri::latest()->get();

    $galeri->transform(function ($item) {
        $item->gambar = Storage::url($item->gambar);
        return $item;
    });

    return response()->json($galeri);
}
}
