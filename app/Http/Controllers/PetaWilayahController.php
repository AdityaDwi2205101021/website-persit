<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetaWilayah;
use Illuminate\Support\Facades\Storage;

class PetaWilayahController extends Controller
{
    public function index()
    {
        return response()->json(PetaWilayah::all());
    }

   public function store(Request $request)
{
    $request->validate([
        'cabang' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
    ]);

    if ($request->hasFile('gambar')) {
        $path = $request->file('gambar')->store('peta', 'public');

        $peta = PetaWilayah::create([
            'cabang' => $request->cabang,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'gambar' => $path,
        ]);

        return response()->json($peta, 201);
    } else {
        return response()->json(['error' => 'Gambar tidak ditemukan'], 400);
    }
    
}
public function update(Request $request, $id)
{
    $peta = PetaWilayah::findOrFail($id);

    $request->validate([
        'cabang' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
    ]);

    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($peta->gambar && Storage::disk('public')->exists($peta->gambar)) {
            Storage::disk('public')->delete($peta->gambar);
        }

        // Simpan gambar baru
        $path = $request->file('gambar')->store('peta', 'public');
        $peta->gambar = $path;
    }

    $peta->cabang = $request->cabang;
    $peta->latitude = $request->latitude;
    $peta->longitude = $request->longitude;
    $peta->save();

    return response()->json($peta);
}
public function destroy($id)
{
    $peta = PetaWilayah::findOrFail($id);

    if ($peta->gambar && Storage::disk('public')->exists($peta->gambar)) {
        Storage::disk('public')->delete($peta->gambar);
    }

    $peta->delete();

    return response()->json(['message' => 'Data berhasil dihapus.']);
}
public function getTitikPublik()
{
    $data = PetaWilayah::all()->map(function ($item) {
        $item->gambar_url = asset('storage/' . $item->gambar);
        return $item;
    });

    return response()->json($data);
}



}