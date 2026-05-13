<?php

namespace App\Wrappers;

use App\Dto\StatsDto;
use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypeEnum;
use App\Models\Exclusion;
use App\Models\Review;
use Illuminate\Support\Carbon;
use UMA\Models\Profesor;
use UMA\Models\ProfesorBasic;
use UMA\Models\Response;

use function count;

class Stats
{
    private const int HALL_MIN_REVIEWS_NEEDED = 10;
    private const int HALL_MAX_COUNT = 5;
    private const int HALL_MIN_AVG = 5;

    public static function all(): StatsDto
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

        return new StatsDto($total, $avg);
    }

    /**
     * @return object{lastRes: Response<Profesor>|Response<ProfesorBasic>|null, data: StatsDto<Profesor>[]}
     */
    public static function weighted(bool $best = true, ?Carbon $within = null): object
    {
        $minReviewsRequired = self::HALL_MIN_REVIEWS_NEEDED; // m
        $api = UMA::api();

        $globalAverage = Review::where('type', ReviewTypeEnum::TEACHER)
            ->when($within !== null, function ($query) use ($within) {
                $query->whereDate('created_at', '>=', $within);
            })
            ->avg('note'); // C

        if ($globalAverage === null) {
            return (object) [
                'lastRes' => null,
                'data' => [],
            ];
        }

        $tops = Review::query()
            ->where('type', ReviewTypeEnum::TEACHER)
            ->whereNotIn('target', Exclusion::all()->pluck('idnc'))
            ->when($within !== null, function ($query) use ($within) {
                $query->whereDate('created_at', '>=', $within);
            })
            ->groupBy('target')
            ->when($best, function ($query) {
                $query->havingRaw('average_note >= ?', [self::HALL_MIN_AVG]);
            })
            ->select('target')
            ->selectRaw('AVG(note) as average_note') // R
            ->selectRaw('COUNT(*) as review_count') // v
            // WR = ( (v / (v+m)) * R ) + ( (m / (v+m)) * C )
            ->selectRaw(
                '(((COUNT(*) / (COUNT(*) + ?)) * AVG(note)) + ((? / (COUNT(*) + ?)) * ?)) AS weighted_rating',
                [$minReviewsRequired, $minReviewsRequired, $minReviewsRequired, $globalAverage],
            )
            ->orderBy('weighted_rating', $best ? 'DESC' : 'ASC')
            ->orderBy('target', 'ASC') // Tie break
            ->limit(self::HALL_MAX_COUNT * 2)
            ->get();

        $hallOfFame = [];

        /** @var Response<Profesor>|Response<ProfesorBasic> */
        $lastRes = null;
        $i = 0;
        while (count($hallOfFame) < self::HALL_MAX_COUNT && $i < $tops->count()) {
            $top = $tops[$i];
            $lastRes = $api->profesorWeb($top->target);
            if ($lastRes->success) {
                $lastRes = $api->profesor($lastRes->data->email);
                if ($lastRes->success) {
                    $hallOfFame[] = new StatsDto(
                        total: $top->review_count,
                        avg: round($top->average_note, 2),
                        for: $lastRes->data,
                    );
                }
            }
            $i++;
        }

        return (object) [
            'lastRes' => $lastRes,
            'data' => $hallOfFame,
        ];
    }

    public static function simple(string $target, ReviewTypeEnum $type): StatsDto
    {
        $reviews = Review::where('target', '=', $target)
            ->where('type', '=', $type)
            ->whereDoesntHave('reports', function ($query) {
                $query->where('status', ReportStatusEnum::ACCEPTED);
            });

        $total = $reviews->count();
        $avg = $total > 0 ? round($reviews->avg('note'), 2) : -1;

        return new StatsDto($total, $avg);
    }
}
