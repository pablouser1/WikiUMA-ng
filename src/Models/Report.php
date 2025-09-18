<?php

namespace App\Models;

use App\Enums\ReportStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
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

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
