<?php

namespace App\Traits;

use App\Constants\App;
use App\Enums\ReviewFilterEnum;
use App\Models\Report;
use App\Models\Review;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasReports
{
    /**
     * Get reviews linked to target.
     *
     * @return LengthAwarePaginator<Review>
     */
    private static function __getReports(int $page, ?ReviewFilterEnum $filter): LengthAwarePaginator
    {
        $query = Report::query();

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

    private static function __getFilter(?string $filter): ?ReviewFilterEnum
    {
        return $filter !== null ? ReviewFilterEnum::tryFrom($filter) : null;
    }
}
