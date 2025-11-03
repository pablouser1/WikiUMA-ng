<?php

namespace App\Enums;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;

/**
 * Enumerate all available filters applicable to reviews.
 */
enum ReviewFilterEnum: string
{
    case AVAILABLE = 'available';
    case ALL = 'all';

    public function displayName(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Disponibles',
            self::ALL => 'Todos',
        };
    }

    public function action(): ?\Closure
    {
        return match ($this) {
            self::AVAILABLE => fn ($builder) => $this->__handleAvailable($builder),
            default => null,
        };
    }

    /**
     * Filter for reviews not removed.
     *
     * @param Builder<Review> $builder
     */
    private function __handleAvailable(Builder &$builder): void
    {
        $builder->whereDoesntHave('reports', function ($query) {
            $query->where('status', ReportStatusEnum::ACCEPTED);
        });
    }
}
