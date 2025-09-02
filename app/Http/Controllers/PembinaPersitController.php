<?php

namespace App\Http\Controllers;

use App\Models\PembinaPersit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembinaPersitController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => PembinaPersit::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $data = $request->only(['nama', 'tanggal_mulai', 'tanggal_berakhir']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_pembina', 'public');
        }

        $pembina = PembinaPersit::create($data);

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $pembina], 201);
    }
    public function update(Request $request, $id)
{
    $pembina = PembinaPersit::findOrFail($id);

    $request->validate([
        'nama' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_berakhir' => 'nullable|date',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
    ]);

    $data = $request->only(['nama', 'tanggal_mulai', 'tanggal_berakhir']);

    if ($request->hasFile('foto')) {
        // hapus foto lama kalau ada
        if ($pembina->foto && Storage::exists('public/' . $pembina->foto)) {
            Storage::delete('public/' . $pembina->foto);
        }
        $data['foto'] = $request->file('foto')->store('foto_pembina', 'public');
    }

    $pembina->update($data);

    return response()->json([
        'message' => 'Data berhasil diupdate',
        'data' => $pembina
    ]);
}
public function destroy($id)
{
    $pembina = PembinaPersit::findOrFail($id);

    if ($pembina->foto && Storage::exists('public/' . $pembina->foto)) {
        Storage::delete('public/' . $pembina->foto);
    }

    $pembina->delete();

    return response()->json(['message' => 'Data berhasil dihapus']);
}

    public function getPublik()
{
    return response()->json([
        'data' => PembinaPersit::select('nama', 'tanggal_mulai', 'tanggal_berakhir', 'foto')->get()
    ]);
}

}
