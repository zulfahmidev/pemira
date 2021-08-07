<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPMCandidate extends Model
{
    use HasFactory;

    public $table = "dpm_cadidates";

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
