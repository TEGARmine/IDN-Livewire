<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangIdn extends Model
{
    use HasFactory;
    protected $table = 'cabangidn';
    protected $guarded = [];

    public function programs()
    {
        return $this->hasMany(ProgramIdn::class, 'cabangidn_id', 'id');
    }
}
