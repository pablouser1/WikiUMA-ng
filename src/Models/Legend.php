<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legend extends Model
{
    protected $table = 'legends';

    protected $fillable = [
        'full_name',
    ];
}
