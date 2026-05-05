<?php
namespace App\Console\Migration;

use App\Wrappers\Storage;

class DbToEmailManualMigrationCommand extends BaseMigration
{

    public function __construct()
    {
        parent::__construct(
            'migration:db2email-manual',
            'Used for teachers that couldn\'t be linked automatically on migration:db2email'
        );
    }

    /**
     * @return int Return code
     */
    public function execute()
    {
        $io = $this->app()->io();
        $w = $io->writer();

        $failed = json_decode(Storage::get('failed-email.json'));
        if ($failed === false) {
            $w->error('Could not get failed json from last step', true);
            return 1;
        }

        $relationsEmail = json_decode(Storage::get('relations-email.json'), true);
        if ($relationsEmail === false) {
            $w->error('Could not get json from last step', true);
            return 1;
        }

        $newLinks = [];

        foreach ($failed as $link) {
            $email = $io->prompt("Write email for {$link->name} ('n' for skip", 'n');
            if ($email !== 'n') {
                $newLinks[$link->id] = $email;
            }
        }

        $mergedLinks = $relationsEmail + $newLinks;

        Storage::save('relations-email-withmanual.json', json_encode($mergedLinks, JSON_PRETTY_PRINT));

        return 0;
    }
}
