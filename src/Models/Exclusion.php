<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exclusion extends Model
{
    protected $table = 'exclusions';

    protected $fillable = [
        'idnc',
    ];
}
