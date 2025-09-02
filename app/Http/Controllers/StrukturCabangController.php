<?php

namespace App\Http\Controllers;

use App\Models\StrukturCabang;
use Illuminate\Http\Request;

class StrukturCabangController extends Controller
{
    public function index()
    {
        // Ambil semua data dengan eager load children untuk hierarki
        $data = StrukturCabang::with('children')->get();
        return response()->json(['struktur' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'cabang' => 'required|string',
            'parent_id' => 'nullable|exists:struktur_cabang,id',
            'foto' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('struktur-cabang', 'public');
        }

        return StrukturCabang::create($data);
    }

    public function show($id)
    {
        $struktur = StrukturCabang::with('children')->findOrFail($id);
        return $struktur;
    }

    public function update(Request $request, $id)
    {
        $struktur = StrukturCabang::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'cabang' => 'required|string',
            'parent_id' => 'nullable|exists:struktur_cabang,id',
            'foto' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('struktur-cabang', 'public');
        }

        $struktur->update($data);
        return $struktur;
    }

    public function destroy($id)
    {
        $struktur = StrukturCabang::findOrFail($id);
        $struktur->delete();

        return response()->json(['message' => 'Data struktur cabang berhasil dihapus']);
    }
   public function getPublic()
{
    $data = StrukturCabang::with('childrenRecursive') // ambil semua level
        ->whereNull('parent_id')
        ->get();

    return response()->json($data);
}

}
