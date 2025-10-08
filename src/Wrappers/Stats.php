<?php

namespace App\Wrappers;

use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;

class Stats
{
    public static function all(): object
    {
        $reviews = Review::whereDoesntHave('reports', function ($query) {
            $query->where('status', ReportStatusEnum::ACCEPTED);
        });
        $total = $reviews->count();
        $avg = round($reviews->avg('note'), 2);

        return (object) [
            'total' => $total,
            'avg' => $avg,
        ];
    }

    public static function fromTarget(string $target, ReviewTypesEnum $type): object
    {
        $reviews = Review::where('target', '=', $target)
            ->where('type', '=', $type)
            ->whereDoesntHave('reports', function ($query) {
                $query->where('status', ReportStatusEnum::ACCEPTED);
            });

        $total = $reviews->count();
        $avg = $total > 0 ? round($reviews->avg('note'), 2) : -1;
        $min = $reviews->min('note');
        $max = $reviews->max('note');

        return (object) [
            'total' => $total,
            'avg' => $avg,
            'min' => $min,
            'max' => $max,
        ];
    }
}
