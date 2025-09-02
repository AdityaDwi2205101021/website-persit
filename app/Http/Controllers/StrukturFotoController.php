<?php

namespace App\Http\Controllers;

use App\Models\StrukturFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturFotoController extends Controller
{
    // Menampilkan foto terakhir
    public function index()
    {
        $foto = StrukturFoto::latest()->first();
        if (!$foto) {
            return response()->json(['message' => 'Belum ada foto'], 404);
        }
        return response()->json($foto);
    }

    // Menyimpan foto baru, hapus data lama
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:10240', // Maks 10MB
            'tanggal_terakhir_diubah' => 'required|date',
        ]);

        // Hapus data lama jika ada
        $oldFoto = StrukturFoto::first();
        if ($oldFoto) {
            if ($oldFoto->foto && Storage::disk('public')->exists($oldFoto->foto)) {
                Storage::disk('public')->delete($oldFoto->foto);
            }
            $oldFoto->delete();
        }

        // Simpan foto baru
        $path = $request->file('foto')->store('struktur_foto', 'public');

        $strukturFoto = StrukturFoto::create([
            'foto' => $path,
            'tanggal_terakhir_diubah' => $request->tanggal_terakhir_diubah,
        ]);

        return response()->json($strukturFoto, 201);
    }

    // Menampilkan foto berdasarkan id (opsional)
    public function show($id)
    {
        $foto = StrukturFoto::findOrFail($id);
        return response()->json($foto);
    }

    // Update foto atau tanggal
    public function update(Request $request, $id)
    {
        $foto = StrukturFoto::findOrFail($id);

        $request->validate([
            'foto' => 'nullable|image|max:10240', // Maks 10MB
            'tanggal_terakhir_diubah' => 'nullable|date',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus file lama
            if ($foto->foto && Storage::disk('public')->exists($foto->foto)) {
                Storage::disk('public')->delete($foto->foto);
            }
            $foto->foto = $request->file('foto')->store('struktur_foto', 'public');
        }

        if ($request->tanggal_terakhir_diubah) {
            $foto->tanggal_terakhir_diubah = $request->tanggal_terakhir_diubah;
        }

        $foto->save();

        return response()->json($foto);
    }

    // Hapus foto
    public function destroy($id)
    {
        $foto = StrukturFoto::findOrFail($id);

        if ($foto->foto && Storage::disk('public')->exists($foto->foto)) {
            Storage::disk('public')->delete($foto->foto);
        }

        $foto->delete();

        return response()->json(['message' => 'Foto berhasil dihapus']);
    }
    // ================== Tambahkan di StrukturFotoController ==================
public function getPublik()
{
    $foto = StrukturFoto::latest()->first();
    if (!$foto) {
        return response()->json(null); // atau ['message'=>'Belum ada foto']
    }
    return response()->json($foto);
}
}

