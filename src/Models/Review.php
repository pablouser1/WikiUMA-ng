<?php

namespace App\Models;

use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function getAcceptedReportAttribute(): ?Report
    {
        return $this->reports()->where('status', '=', ReportStatusEnum::ACCEPTED)->first();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'reviews_tags');
    }
}
