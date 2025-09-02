<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembinaPersit extends Model
{
     use HasFactory;
 
    protected $fillable = ['nama', 'tanggal_mulai', 'tanggal_berakhir', 'foto'];
}
