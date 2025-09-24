<?php

namespace App\Observers;

use App\Models\Report;

class ReportObserver
{
    public function created(Report $report): void
    {
        logger()->info('New report registered', [
            'uuid' => $report->uuid,
            'target' => $report->review->target,
            'type' => $report->review->type->displayName()
        ]);
    }
}
