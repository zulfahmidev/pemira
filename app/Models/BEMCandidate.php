<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BEMCandidate extends Model
{
    use HasFactory;

    public $table = "bem_cadidates";

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
