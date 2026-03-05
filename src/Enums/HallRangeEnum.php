<?php

namespace App\Enums;

use Illuminate\Support\Carbon;

enum HallRangeEnum: string
{
    case LAST_WEEK = "week";
    case LAST_MONTH = "month";
    case LAST_YEAR = "year";
    case ALL_TIMES = "all";

    public function displayName(): string
    {
        return match($this) {
            self::LAST_WEEK => 'Últimos 7 días',
            self::LAST_MONTH => 'Último mes',
            self::LAST_YEAR => 'Último año',
            self::ALL_TIMES => 'Siempre',
        };
    }

    public function carbon(): ?Carbon
    {
        $now = Carbon::now();

        return match($this) {
            self::LAST_WEEK => $now->subWeek(),
            self::LAST_MONTH => $now->subMonth(),
            self::LAST_YEAR => $now->subYear(),
            self::ALL_TIMES => null,
        };
    }
}
