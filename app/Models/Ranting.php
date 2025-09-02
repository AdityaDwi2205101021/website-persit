<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranting extends Model
{
    use HasFactory;

    protected $table = 'Rantings';

    protected $fillable = [
        'foto',
        'tanggal_terakhir_diubah',
    ];
}
