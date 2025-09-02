<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        return response()->json($anggota);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'pendidikan_terakhir' => 'required|in:smp,sma,smk,d1,d2,d3,d4,s1,s2,s3',
            'jurusan' => 'nullable|string',
            'nama_suami' => 'nullable|string',
            'pangkat_nrp' => 'nullable|string',
            'jumlah_anak' => 'nullable|integer|min:0',
            'pekerjaan' => 'nullable|string',
            'tanggal_menikah' => 'nullable|date',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('anggota', 'public');
        }

        $anggota = Anggota::create([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jurusan' => $request->jurusan,
            'nama_suami' => $request->nama_suami,
            'pangkat_nrp' => $request->pangkat_nrp,
            'jumlah_anak' => $request->jumlah_anak,
            'pekerjaan' => $request->pekerjaan,
            'tanggal_menikah' => $request->tanggal_menikah,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan,
            'foto' => $fotoPath,
        ]);

        return response()->json([
            'message' => 'Anggota berhasil ditambahkan',
            'data' => $anggota
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'pendidikan_terakhir' => 'required|in:smp,sma,smk,d1,d2,d3,d4,s1,s2,s3',
            'jurusan' => 'nullable|string',
            'nama_suami' => 'nullable|string',
            'pangkat_nrp' => 'nullable|string',
            'jumlah_anak' => 'nullable|integer|min:0',
            'pekerjaan' => 'nullable|string',
            'tanggal_menikah' => 'nullable|date',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $anggota->nama = $request->nama;
        $anggota->tempat_lahir = $request->tempat_lahir;
        $anggota->tanggal_lahir = $request->tanggal_lahir;
        $anggota->pendidikan_terakhir = $request->pendidikan_terakhir;
        $anggota->jurusan = $request->jurusan;
        $anggota->nama_suami = $request->nama_suami;
        $anggota->pangkat_nrp = $request->pangkat_nrp;
        $anggota->jumlah_anak = $request->jumlah_anak;
        $anggota->pekerjaan = $request->pekerjaan;
        $anggota->tanggal_menikah = $request->tanggal_menikah;
        $anggota->alamat = $request->alamat;
        $anggota->keterangan = $request->keterangan;

        if ($request->hasFile('foto')) {
            if ($anggota->foto) {
                Storage::delete('public/' . $anggota->foto);
            }
            $foto = $request->file('foto')->store('anggota', 'public');
            $anggota->foto = $foto;
        }

        $anggota->save();

        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        if ($anggota->foto) {
            Storage::delete('public/' . $anggota->foto);
        }

        $anggota->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
    public function publicSummary()
{
    $totalAnggota = Anggota::count();
    $totalSMA = Anggota::where('pendidikan_terakhir', 'sma')->count();
    $totalSMK = Anggota::where('pendidikan_terakhir', 'smk')->count();
    $totalSarjana = Anggota::whereIn('pendidikan_terakhir', ['s1', 's2', 's3'])->count();
    $totalDiploma = Anggota::whereIn('pendidikan_terakhir', ['d1','d2','d3','d4'])->count();
    $totalBekerja = Anggota::whereNotNull('pekerjaan')->where('pekerjaan', '!=', '')->count();
    $totalAnak = Anggota::sum('jumlah_anak');

    return response()->json([
        'total_anggota' => $totalAnggota,
        'pendidikan' => [
            'sma' => $totalSMA,
            'smk' => $totalSMK,
            'diploma' => $totalDiploma,
            'sarjana' => $totalSarjana,
        ],
        'total_bekerja' => $totalBekerja,
        'total_anak' => $totalAnak
    ]);
}

}
