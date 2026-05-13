<?php

namespace App\Traits;

use App\Constants\App;
use App\Dto\StatsDto;
use App\Enums\ReviewFilterEnum;
use App\Enums\ReviewTypeEnum;
use App\Models\Review;
use App\Wrappers\Stats;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasReviews
{
    /**
     * Get reviews linked to target.
     *
     * @return LengthAwarePaginator<Review>
     */
    private static function __getReviews(?string $target, ?ReviewTypeEnum $type, int $page, ?ReviewFilterEnum $filter): LengthAwarePaginator
    {
        $query = Review::latest();

        if ($target !== null && $type !== null) {
            $query->where('target', '=', $target)
                ->where('type', '=', $type);
        }

        $filter ??= ReviewFilterEnum::AVAILABLE;
        $action = $filter->action();
        if ($action !== null) {
            $action($query);
        }

        return $query->paginate(
            perPage: App::PAGINATION_MAX_ITEMS,
            page: $page,
        );
    }

    /**
     * Get stats linked to target.
     */
    private static function __getStatsSimple(string $target, ReviewTypeEnum $type): StatsDto
    {
        return Stats::simple($target, $type);
    }

    private static function __getReviewFilter(?string $filter): ?ReviewFilterEnum
    {
        return $filter !== null ? ReviewFilterEnum::tryFrom($filter) : null;
    }
}
