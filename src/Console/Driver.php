<?php
namespace App\Console;

use App\Console\Modules\TagsModule;

class Driver extends Base implements IBase
{
    private const array OPTIONS = [
        [
            'name' => 'Tags',
            'runner' => [TagsModule::class, 'entrypoint'],
        ],
    ];

    public function entrypoint(): void
    {
        $this->cli->bold()->out("Welcome to WikiUMA-ng!");
        $this->radio(self::OPTIONS);
    }
}
