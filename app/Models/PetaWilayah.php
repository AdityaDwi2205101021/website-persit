<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaWilayah extends Model
{
    use HasFactory;

    protected $table = 'petas';
    protected $fillable = ['cabang', 'latitude', 'longitude', 'gambar'];
}
