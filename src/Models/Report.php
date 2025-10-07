<?php

namespace App\Models;

use App\Enums\ReportStatusEnum;
use App\Observers\ReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ReportObserver::class)]
class Report extends Model
{
    private const string DEFAULT_REASON_VALUE = "Sin especificar";

    protected $table = 'reports';

    protected $fillable = [
        'uuid',
        'review_id',
        'message',
        'reason',
        'email',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => ReportStatusEnum::class,
        ];
    }

    protected function reason(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value === null ? self::DEFAULT_REASON_VALUE : $value,
        );
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
