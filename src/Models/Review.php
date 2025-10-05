<?php

namespace App\Models;

use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypesEnum;
use App\Observers\ReviewObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(ReviewObserver::class)]
class Review extends Model
{
    private const string DEFAULT_USERNAME_VALUE = "Anónimo";

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

    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value === null ? self::DEFAULT_USERNAME_VALUE : $value,
        );
    }

    /**
     * Get first accepted report linked to review.
     */
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
