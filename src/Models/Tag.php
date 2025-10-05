<?php

namespace App\Models;

use App\Enums\ReviewTypesEnum;
use App\Enums\TagTypesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'name',
        'type',
        'for',
        'icon',
    ];

    protected function casts(): array
    {
        return [
            'type' => TagTypesEnum::class,
            'for' => ReviewTypesEnum::class,
        ];
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(Review::class, 'reviews_tags');
    }
}
