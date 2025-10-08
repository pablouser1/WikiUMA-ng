<?php

namespace App\Console\Modules;

use App\Api;
use App\Console\Base;
use App\Console\IBase;
use App\Wrappers\Storage;
use League\CLImate\CLImate;

/**
 * CLI migrator from old WikiUMA (rip).
 */
class MigrateOldModule extends Base implements IBase
{
    private const string DB_FILENAME = "old.db";

    private \SQLite3 $db;
    private Api $api;

    public function __construct(CLImate $cli)
    {
        parent::__construct($cli);
        $this->db = new \Sqlite3(Storage::path(self::DB_FILENAME), SQLITE3_OPEN_READONLY);
        $this->api = new Api();
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function entrypoint(): void
    {
        $this->__migrateTeachers();
    }

    private function __migrateTeachers(): void
    {
        $res = $this->db->query('SELECT * FROM profesor');

        if ($res === false) {
            $this->cli->backgroundRed()->error('DB error for teacher');
            return;
        }

        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            var_dump($row);
        }
    }
}
