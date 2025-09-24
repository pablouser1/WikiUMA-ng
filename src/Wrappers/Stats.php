<?php

namespace App\Wrappers;

use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class Stats
{
    public static function all(): object
    {
        $reviews = Review::all();
        $count = $reviews->count();

        return (object) [
            'total' => $count,
        ];
    }

    public static function fromTarget(string $target, ReviewTypesEnum $type): object
    {
        $reviews = Review::where('target', '=', $target)
            ->where('type', '=', $type);

        $total = $reviews->count();
        $avg = round($reviews->avg('note'), 2);
        $min = $reviews->min('note');
        $max = $reviews->max('note');
        $tags = self::__getMostUsedTags($target, $type);

        return (object) [
            'total' => $total,
            'avg' => $avg,
            'min' => $min,
            'max' => $max,
            'tags' => $tags,
        ];
    }

    /**
     * Get most used tags from target.
     *
     * @return Collection<int, Tag> $tags
     */
    private static function __getMostUsedTags(string $target, ReviewTypesEnum $type): Collection
    {
        $tags = Tag::withCount(['reviews as review_count' => function ($query) use ($target, $type) {
            $query->where('target', $target)->where('type', $type);
        }])
            ->having('review_count', '>', 0)
            ->orderBy('review_count', 'desc')
            ->limit(3)
            ->get();

        return $tags;
    }
}
