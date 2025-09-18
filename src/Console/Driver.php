<?php

namespace App\Console;

use App\Console\Modules\MigrateOldModule;
use App\Console\Modules\ReportsModule;
use App\Console\Modules\SeederModule;
use App\Console\Modules\TagsModule;

class Driver extends Base implements IBase
{
    private const array OPTIONS = [
        [
            'name' => 'Tags',
            'runner' => [TagsModule::class, 'entrypoint'],
        ],
        [
            'name' => 'Reports',
            'runner' => [ReportsModule::class, 'entrypoint'],
        ],
        [
            'name' => 'Seed',
            'runner' => [SeederModule::class, 'entrypoint'],
        ],
        [
            'name' => 'Migrate from old version',
            'runner' => [MigrateOldModule::class, 'entrypoint'],
        ],
    ];

    public function entrypoint(): void
    {
        $this->cli->bold()->out("Welcome to WikiUMA-ng!");
        $this->radio(self::OPTIONS);
    }
}
