<?php

namespace App\Wrappers;

use App\Api;
use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypesEnum;
use App\Models\Api\Response;
use App\Models\Review;

class Stats
{
    private const int HALL_MIN_REVIEWS_NEEDED = 10;
    private const int HALL_MAX_COUNT = 5;

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

    public static function weighted(bool $best = true): object
    {
        $minReviewsRequired = self::HALL_MIN_REVIEWS_NEEDED; // m
        $api = new Api();

        $globalAverage = Review::where('type', ReviewTypesEnum::TEACHER)->avg('note'); // C
        $tops = Review::query()
            ->where('type', ReviewTypesEnum::TEACHER)
            ->groupBy('target')
            ->select('target')
            ->selectRaw('AVG(note) as average_note') // R
            ->selectRaw('COUNT(*) as review_count') // v
            // WR = ( (v / (v+m)) * R ) + ( (m / (v+m)) * C )
            ->selectRaw(
                "(((COUNT(*) / (COUNT(*) + {$minReviewsRequired})) * AVG(note)) + (( {$minReviewsRequired} / (COUNT(*) + {$minReviewsRequired})) * {$globalAverage})) AS weighted_rating"
            )
            ->orderBy('weighted_rating', $best ? 'DESC' : 'ASC')
            ->limit(self::HALL_MAX_COUNT)
            ->get();

        $hallOfFame = [];
        $lastRes = new Response(200, ['ok' => true], false);
        $i = 0;
        while ($lastRes->success && $i < $tops->count()) {
            $top = $tops[$i];
            $lastRes = $api->profesorWeb($top->target);
            if ($lastRes->success) {
                $email = $lastRes->data->email;
                $lastRes = $api->profesor($email);
                if ($lastRes->success) {
                    $hallOfFame[] = (object) [
                        'teacher' => $lastRes->data,
                        'avg' => round($top->average_note, 2),
                        'total' => $top->review_count,
                    ];
                }
            }
            $i++;
        }

        return (object) [
            'lastRes' => $lastRes,
            'data' => $hallOfFame,
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
