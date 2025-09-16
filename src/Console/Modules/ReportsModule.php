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
            $this->cli->out($report->message);
            $this->cli->br();
            $this->cli->bold('Original message:');
            $this->cli->out($report->review->message);
        }
    }
}
