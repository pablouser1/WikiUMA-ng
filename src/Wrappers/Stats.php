<?php

namespace App\Wrappers;

use App\Api;
use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypesEnum;
use App\Models\Api\Response;
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

    public static function hallOfFame(): object
    {
        $api = new Api();
        $tops = Review::query()
            ->where('type', ReviewTypesEnum::TEACHER)
            ->groupBy('target')
            ->select('target')
            ->selectRaw('AVG(note) as average_note')
            ->selectRaw('COUNT(*) as review_count')
            ->orderByDesc('average_note')
            ->orderByDesc('review_count')
            ->limit(5)
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
                        'avg' => $top->average_note,
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
