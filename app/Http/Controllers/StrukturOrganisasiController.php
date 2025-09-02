<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $data = StrukturOrganisasi::all();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'foto' => 'nullable|image|max:10240',
            'parent_id' => 'nullable|exists:struktur_organisasis,id',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        $struktur = StrukturOrganisasi::create($data);
        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $struktur]);
    }

    public function show($id)
    {
        $struktur = StrukturOrganisasi::findOrFail($id);
        return response()->json(['data' => $struktur]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'foto' => 'nullable|image|max:10240',
            'parent_id' => 'nullable|exists:struktur_organisasis,id',
        ]);

        $struktur = StrukturOrganisasi::findOrFail($id);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        $struktur->update($data);
        return response()->json(['message' => 'Data berhasil diupdate', 'data' => $struktur]);
    }

    public function destroy($id)
    {
        $struktur = StrukturOrganisasi::findOrFail($id);
        $struktur->delete();
        return response()->json(['message' => 'Data dihapus']);
    }

    // ✅ Ini adalah versi publik yang berbentuk struktur pohon
    public function getPublik()
    {
        $data = StrukturOrganisasi::orderBy('id')->get();
        return response()->json(['data' => $data]);
    }
}
