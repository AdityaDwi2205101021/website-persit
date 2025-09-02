<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturCabang extends Model
{
    use HasFactory;

    protected $table = 'struktur_cabang';

    protected $fillable = [
        'nama',
        'jabatan',
        'cabang',
        'parent_id',
        'foto',
    ];

    // Relasi parent (jabatan induk)
    public function parent()
    {
        return $this->belongsTo(StrukturCabang::class, 'parent_id');
    }

    public function children()
{
    return $this->hasMany(StrukturCabang::class, 'parent_id');
}

public function childrenRecursive()
{
    return $this->children()->with('childrenRecursive');
}

}
