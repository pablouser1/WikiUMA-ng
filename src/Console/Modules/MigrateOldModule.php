<?php
namespace App\Console\Modules;

use App\Api;
use App\Console\Base;
use App\Console\IBase;

class MigrateOldModule extends Base implements IBase
{
    public function entrypoint(): void
    {
        $in = $this->cli->input("Write path of SQLite3 DB:");
        $path = $in->prompt();

        $db = new \Sqlite3($path, SQLITE3_OPEN_READONLY);
        $api = new Api;

        $this->__migrateTeachers($db, $api);

        $db->close();
    }

    private function __migrateTeachers(\SQLite3 $db, Api $api): void
    {
        $res = $db->query('SELECT * FROM profesor');

        if ($res === false) {
            $this->cli->backgroundRed()->error('DB error for teacher');
            return;
        }

        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            var_dump($row);
        }
    }
}
