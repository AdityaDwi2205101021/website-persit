<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $fillable = ['nama', 'jabatan', 'foto', 'parent_id'];

    public function children()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(StrukturOrganisasi::class, 'parent_id');
    }
}
