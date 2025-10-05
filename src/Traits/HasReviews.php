<?php

namespace App\Traits;

use App\Constants\App;
use App\Enums\ReviewFilterEnum;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Models\Tag;
use App\Wrappers\Stats;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasReviews
{
    /**
     * Get reviews linked to target.
     *
     * @return LengthAwarePaginator<Review>
     */
    private static function __getReviews(string $target, ReviewTypesEnum $type, int $page, ?ReviewFilterEnum $filter): LengthAwarePaginator
    {
        $query = Review::latest()->where('target', '=', $target)
            ->where('type', '=', $type);

        if ($filter !== null) {
            $action = $filter->action();
            if ($action !== null) {
                $action($query);
            }
        }

        return $query->paginate(
            perPage: App::PAGINATION_MAX_ITEMS,
            page: $page
        );
    }

    /**
     * Get stats linked to target.
     */
    private static function __getStats(string $target, ReviewTypesEnum $type): object
    {
        return Stats::fromTarget($target, $type);
    }

    /**
     * Get tags for specific type.
     *
     * @return Collection<int, Tag>
     */
    private static function __getTags(ReviewTypesEnum $type): Collection
    {
        return Tag::where('for', '=', $type)->get();
    }

    private static function __getFilter(?string $filter): ?ReviewFilterEnum
    {
        return $filter !== null ? ReviewFilterEnum::tryFrom($filter) : null;
    }
}
