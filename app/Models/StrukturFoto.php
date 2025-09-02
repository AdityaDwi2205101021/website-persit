<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturFoto extends Model
{
    use HasFactory;

    protected $table = 'struktur_fotos';

    protected $fillable = [
        'foto',
        'tanggal_terakhir_diubah',
    ];
}
