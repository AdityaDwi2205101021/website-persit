<?php
namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        return response()->json(Berita::latest()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita = Berita::create($data);
        return response()->json($berita, 201);
    }

    public function show($id)
    {
        return response()->json(Berita::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);
        return response()->json($berita);
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        return response()->json(['message' => 'Berita dihapus']);
    }
    public function terbaru()
{
    $berita = Berita::latest()->get(); 
    return response()->json($berita);
}

}
