<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $table = 'santri';
    protected $guarded = [];

    public function programidn()
    {
        return $this->belongsTo(ProgramIdn::class, 'cabangidn_id', 'id');
    }
}
