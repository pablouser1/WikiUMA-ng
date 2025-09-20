<?php

namespace App\Traits;

use App\Constants\App;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Models\Tag;
use App\Wrappers\Stats;
use Illuminate\Database\Eloquent\Collection;

trait HasReviews
{
    /**
     * Get reviews linked to target.
     *
     * @return Collection<int, Review>
     */
    private static function __getReviews(string $target, ReviewTypesEnum $type, int $page): Collection
    {
        return Review::where('target', '=', $target)
            ->where('type', '=', $type)
            ->paginate(
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
}
