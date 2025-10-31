<?php

namespace App\Console\Modules;

use App\Api;
use App\Console\Base;
use App\Console\IBase;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Misc;
use App\Wrappers\Stats;
use App\Wrappers\Storage;
use League\CLImate\CLImate;

/**
 * Migrate from old WikiUMA (rip).
 */
class StatsModule extends Base implements IBase
{
    private const array OPTIONS = [
        [
            'name' => 'Highest',
            'runner' => [self::class, 'highest'],
        ],
        [
            'name' => 'Lowest',
            'runner' => [self::class, 'lowest'],
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function entrypoint(): void
    {
        $this->cli->bold()->out('Stats');
        $this->radio(self::OPTIONS);
    }

    public function highest(): void
    {
        $this->__ranking(true);
    }

    public function lowest(): void
    {
        $this->__ranking(false);
    }

    private function __ranking(bool $best): void
    {
        $weighted = Stats::weighted($best);
        if (!$weighted->lastRes->success) {
            $this->cli->error($weighted->lastRes->error);
            return;
        }

        foreach ($weighted->data as $item) {
            $this->cli->out("{$item->teacher->nombre}: {$item->total} valoraciones | {$item->avg} media");
        }
    }
}
