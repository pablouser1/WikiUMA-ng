<?php
namespace App\Console\Migration;

use App\Wrappers\Storage;

use function count;

class EmailToIdncMigrationCommand extends BaseMigration
{

    public function __construct()
    {
        parent::__construct(
            'migration:email2idnc',
            'Relate email to idnc'
        );
    }

    /**
     * @return int Return code
     */
    public function execute()
    {
        $io = $this->app()->io();
        $w = $io->writer();

        $relationsEmail = json_decode(Storage::get('relations-email.json'));
        if ($relationsEmail === false) {
            $w->error('Could not get json from last step', true);
            return 1;
        }

        $api = $this->api();

        $relationsIdnc = [];
        $failed = [];

        foreach ($relationsEmail as $id => $email) {
            $profesor = $api->profesor($email);
            if (!$profesor->success) {
                $failed[] = $email;
            }

            $relationsIdnc[$id] = $profesor->data->idnc;
        }

        Storage::save('relations-idnc.json', json_encode($relationsIdnc, JSON_PRETTY_PRINT));
        Storage::save('failed-idnc.json', json_encode($failed, JSON_PRETTY_PRINT));

        $w->info('IDNCs obtained: ' . count($relationsIdnc), true);
        $w->info('Failed: ' . count($failed), true);

        return 0;
    }
}
