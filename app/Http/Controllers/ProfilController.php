<?php
namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Profil::all();
        return response()->json(['profil' => $profil]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('profil', 'public');
        }

        Profil::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
        ]);

        return response()->json(['message' => 'Profil berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $profil = Profil::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('gambar')) {
            if ($profil->gambar) {
                Storage::disk('public')->delete($profil->gambar);
            }
            $profil->gambar = $request->file('gambar')->store('profil', 'public');
        }

        $profil->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $profil->gambar,
        ]);

        return response()->json(['message' => 'Profil berhasil diupdate']);
    }

    public function destroy($id)
    {
        $profil = Profil::findOrFail($id);

        if ($profil->gambar) {
            Storage::disk('public')->delete($profil->gambar);
        }

        $profil->delete();

        return response()->json(['message' => 'Profil berhasil dihapus']);
    }
    public function showPublic()
{
    $profil = Profil::latest()->first(); // ambil profil terbaru
    return response()->json($profil);
}

}
