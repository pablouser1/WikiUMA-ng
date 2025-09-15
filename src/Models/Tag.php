<?php

namespace App\Models;

use App\Enums\TagTypesEnum;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'name',
        'type',
        'icon',
    ];

    protected function casts(): array
    {
        return [
            'type' => TagTypesEnum::class,
        ];
    }
}
