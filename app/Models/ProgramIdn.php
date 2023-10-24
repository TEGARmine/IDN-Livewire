<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramIdn extends Model
{
    use HasFactory;
    protected $table = 'programidn';
    protected $guarded = [];

    public function cabangs()
    {
        return $this->belongsTo(CabangIdn::class, 'id', 'cabangidn_id');
    }

    public function santris()
    {
        return $this->hasMany(Santri::class, 'programidn_id', 'id');
    }
}
