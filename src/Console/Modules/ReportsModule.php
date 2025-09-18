<?php
namespace App\Console\Modules;

use App\Console\Base;
use App\Console\IBase;
use App\Enums\ReportStatusEnum;
use App\Models\Report;

class ReportsModule extends Base implements IBase
{
    private const array OPTIONS = [
        [
            'name' => 'Look pending',
            'runner' => [self::class, 'pending'],
        ],
    ];

    private const array ACTIONS = [
        [
            'name' => 'Accept',
            'runner' => [self::class, 'actions_accept'],
        ],
        [
            'name' => 'Deny',
            'runner' => [self::class, 'actions_deny'],
        ],
        [
            'name' => 'Ignore',
            'runner' => [self::class, 'actions_ignore'],
        ],
    ];

    public function entrypoint(): void
    {
        $this->cli->bold()->out('Reports');
        $this->radio(self::OPTIONS);
    }

    public function pending(): void
    {
        $reports = Report::where('status', '=', ReportStatusEnum::PENDING)->get();
        $count = $reports->count();

        foreach ($reports as $i => $report) {
            $num = $i + 1;
            $this->cli->bold("Report $num / $count:");
            $this->cli->out(strip_tags($report->message));
            $this->cli->br();
            $this->cli->bold('Original message:');
            $this->cli->out(strip_tags($report->review->message));

            $this->radio(self::ACTIONS, [
                'report' => $report,
            ]);
        }
    }

    public function actions_accept(Report $report): void
    {
        $report->status = ReportStatusEnum::ACCEPTED;
        $report->save();
        $this->cli->bold('Report accepted.');
        // TODO: Send email if available
    }

    public function actions_deny(Report $report): void
    {
        $report->status = ReportStatusEnum::DENIED;
        $report->save();
        $this->cli->bold('Report denied.');
        // TODO: Send email if available
    }

    public function actions_ignore(Report $report): void
    {
        $this->cli->bold('Report ignored.');
        // TODO: Send email if available
    }
}
