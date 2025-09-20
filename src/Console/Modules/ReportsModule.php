<?php

namespace App\Console\Modules;

use App\Console\Base;
use App\Console\IBase;
use App\Enums\ReportStatusEnum;
use App\Models\Report;
use League\CLImate\CLImate;

class ReportsModule extends Base implements IBase
{

    public function __construct(CLImate $cli)
    {
        parent::__construct($cli);
    }

    private const array OPTIONS = [
        [
            'name' => 'Look pending',
            'runner' => [self::class, 'pending'],
        ],
    ];

    private const array ACTIONS = [
        [
            'name' => 'Accept',
            'runner' => [self::class, 'actionsAccept'],
        ],
        [
            'name' => 'Deny',
            'runner' => [self::class, 'actionsDeny'],
        ],
        [
            'name' => 'Skip',
            'runner' => [self::class, 'actionsSkip'],
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

    public function actionsAccept(Report $report): void
    {
        $this->__actionsCommon($report, ReportStatusEnum::ACCEPTED);
    }

    public function actionsDeny(Report $report): void
    {
        $this->__actionsCommon($report, ReportStatusEnum::DENIED);
    }

    public function actionsSkip(Report $report): void
    {
        $this->__actionsCommon($report, ReportStatusEnum::PENDING);
    }

    private function __actionsCommon(Report $report, ReportStatusEnum $status): void
    {
        if ($status === ReportStatusEnum::PENDING) {
            return;
        }

        $report->status = $status;

        // Choose reason
        $in = $this->cli->input("Choose a reason (or leave empty for none): ");
        $reason = $in->prompt();

        if (!empty($reason)) {
            $report->reason = $reason;
        }

        // Save and send email if available
        $report->save();
        $this->cli->backgroundGreen()->bold('OK');
    }
}
