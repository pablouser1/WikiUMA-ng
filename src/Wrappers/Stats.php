<?php

namespace App\Wrappers;

use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;

class Stats
{
    public static function all(): object
    {
        $query = Review::whereDoesntHave('reports', function ($query) {
            $query->where('status', ReportStatusEnum::ACCEPTED);
        });

        $total = $query->count();

        // Get average of averages of all targets
        $targetAverages = $query
            ->selectRaw('target, AVG(note) as avg_note')
            ->groupBy('target')
            ->get();

        $avg = $total > 0 && $targetAverages->isNotEmpty() ? round($targetAverages->avg('avg_note'), 2) : -1;

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
