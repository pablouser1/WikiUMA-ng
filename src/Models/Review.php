<?php

namespace App\Models;

use App\Enums\ReviewTypesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'target',
        'username',
        'note',
        'message',
        'votes',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => ReviewTypesEnum::class,
        ];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'reviews_tags');
    }
}
