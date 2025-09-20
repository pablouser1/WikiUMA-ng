<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Builder;

enum ReportFilterEnum: string
{
    case ALL = 'all';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DENIED = 'denied';

    public function action(): ?\Closure
    {
        return match ($this) {
            self::PENDING => fn ($builder) => $this->__handleStatus($builder, ReportStatusEnum::PENDING),
            self::ACCEPTED => fn ($builder) => $this->__handleStatus($builder, ReportStatusEnum::ACCEPTED),
            self::DENIED => fn ($builder) => $this->__handleStatus($builder, ReportStatusEnum::DENIED),
            default => null,
        };
    }

    /**
     * Filter for reviews not removed.
     *
     * @param Builder<Review> $builder
     */
    private function __handleStatus(Builder &$builder, ReportStatusEnum $status): void
    {
        $builder->whereDoesntHave('reports', function ($query) use ($status) {
            $query->where('status', $status);
        });
    }
}
