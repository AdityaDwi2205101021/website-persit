<?php

namespace App\Http\Controllers;

use App\Models\PimpinanPersit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PimpinanPersitController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => PimpinanPersit::all()
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
            $data['foto'] = $request->file('foto')->store('foto_pimpinan', 'public');
        }

        $pimpinan = PimpinanPersit::create($data);

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $pimpinan], 201);
    }
    public function update(Request $request, $id)
{
    $pimpinan = PimpinanPersit::findOrFail($id);

    $request->validate([
        'nama' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_berakhir' => 'nullable|date',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
    ]);

    $data = $request->only(['nama', 'tanggal_mulai', 'tanggal_berakhir']);

    if ($request->hasFile('foto')) {
        // hapus foto lama kalau ada
        if ($pimpinan->foto && Storage::exists('public/' . $pimpinan->foto)) {
            Storage::delete('public/' . $pimpinan->foto);
        }
        $data['foto'] = $request->file('foto')->store('foto_pimpinan', 'public');
    }

    $pimpinan->update($data);

    return response()->json([
        'message' => 'Data berhasil diupdate',
        'data' => $pimpinan
    ]);
}
public function destroy($id)
{
    $pimpinan = PimpinanPersit::findOrFail($id);

    if ($pimpinan->foto && Storage::exists('public/' . $pimpinan->foto)) {
        Storage::delete('public/' . $pimpinan->foto);
    }

    $pimpinan->delete();

    return response()->json(['message' => 'Data berhasil dihapus']);
}

    public function getPublik()
{
    return response()->json([
        'data' => PimpinanPersit::select('nama', 'tanggal_mulai', 'tanggal_berakhir', 'foto')->get()
    ]);
}

}
