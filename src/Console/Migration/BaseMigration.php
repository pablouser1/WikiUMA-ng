<?php
namespace App\Console\Migration;

use Ahc\Cli\Input\Command;
use App\Wrappers\Storage;
use App\Wrappers\UMA;
use UMA\Api;

abstract class BaseMigration extends Command
{
    private const string DB_FILENAME = 'old.db';

    public function api(): Api
    {
        return UMA::api();
    }

    public function db(): \SQLite3
    {
        return new \SQLite3(Storage::path(self::DB_FILENAME), SQLITE3_OPEN_READONLY);
    }
}
