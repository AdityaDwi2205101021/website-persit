<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan_terakhir',
        'jurusan',
        'nama_suami',
        'pangkat_nrp',
        'jabatan',
        'jumlah_anak',
        'pekerjaan',
        'tanggal_menikah',
        'alamat',
        'keterangan',
        'foto',
    ];

    protected $dates = [
        'tanggal_lahir',
        'tanggal_menikah',
    ];
}
