<?php

namespace App\Console\Modules;

use App\Console\Base;
use App\Console\IBase;
use App\Enums\ReportStatusEnum;
use App\Models\Report;
use App\Wrappers\Mail;
use League\CLImate\CLImate;

/**
 * Reports administration.
 */
class ReportsModule extends Base implements IBase
{
    private Mail $mail;

    public function __construct(CLImate $cli)
    {
        parent::__construct($cli);
        $this->mail = new Mail();
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

    /**
     * {@inheritdoc}
     */
    public function entrypoint(): void
    {
        $this->cli->bold()->out('Reports');
        $this->radio(self::OPTIONS);
    }

    /**
     * List pending reports and let the user choose between actions.
     */
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

    /**
     * Accept the report, deleting the review.
     */
    public function actionsAccept(Report $report): void
    {
        $this->__actionsCommon($report, ReportStatusEnum::ACCEPTED);
    }

    /**
     * Deny the report, keeping the review.
     */
    public function actionsDeny(Report $report): void
    {
        $this->__actionsCommon($report, ReportStatusEnum::DENIED);
    }

    /**
     * Temporally ignore review.
     */
    public function actionsSkip(Report $report): void
    {
        $this->__actionsCommon($report, ReportStatusEnum::PENDING);
    }

    /**
     * Common function to handle actions.
     */
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
        if (!empty($report->email)) {
            $ok = $this->mail->reportStatus($report);
            $this->cli->backgroundYellow()->bold('Report was saved, but could not send email');
        }
        $this->cli->backgroundGreen()->bold('OK');
    }
}
