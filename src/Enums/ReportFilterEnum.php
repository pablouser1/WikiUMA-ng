<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Builder;

enum ReportFilterEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DENIED = 'denied';
    case ALL = 'all';

    public function displayName(): string
    {
        return match ($this) {
            self::PENDING => 'Pendientes',
            self::ACCEPTED => 'Aceptados',
            self::DENIED => 'Denegados',
            self::ALL => 'Todos',
        };
    }

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
        $builder->where('status', '=', $status);
    }
}
