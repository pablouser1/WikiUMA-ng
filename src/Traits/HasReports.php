<?php

namespace App\Traits;

use App\Constants\App;
use App\Enums\ReportFilterEnum;
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
    private static function __getReports(int $page, ?ReportFilterEnum $filter): LengthAwarePaginator
    {
        $query = Report::latest();

        // Default filter to pending
        $filter = $filter ?? ReportFilterEnum::PENDING;

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

    private static function __getReportFilter(?string $filter): ?ReportFilterEnum
    {
        return $filter !== null ? ReportFilterEnum::tryFrom($filter) : null;
    }
}
