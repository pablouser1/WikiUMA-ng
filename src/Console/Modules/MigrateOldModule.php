<?php

namespace App\Console\Modules;

use App\Api;
use App\Console\Base;
use App\Console\IBase;
use App\Wrappers\Misc;
use App\Wrappers\Storage;
use League\CLImate\CLImate;

/**
 * CLI migrator from old WikiUMA (rip).
 */
class MigrateOldModule extends Base implements IBase
{
    private const string DB_FILENAME = "old.db";
    private const string USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36";

    private const array OPTIONS = [
        [
            'name' => 'Link db users with email',
            'runner' => [self::class, 'dbToEmail'],
        ],
    ];

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
        $this->cli->bold()->out('Migrations');
        $this->radio(self::OPTIONS);
    }

    public function dbToEmail(): void
    {
        $dps = $this->api->departamentos('a02');
        if (!$dps->success) {
            $this->cli->backgroundRed()->error('Could not get departments');
            return;
        }

        $dpNames = array_map(fn($dp) => $this->__normalize($dp->nombre), $dps->data);

        $ch = curl_init('https://www.uma.es/etsi-informatica/info/10610/departamentos/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_USERAGENT => self::USER_AGENT,
        ]);

        $result = curl_exec($ch);
        if ($result === false) {
            $this->cli->backgroundRed()->error('Could not get departments from website');
            return;
        }

        $dpsWeb = [];

        $dom = Misc::parseHTML($result);
        $xpath = new \DOMXPath($dom);
        $els = $xpath->query("//ul[contains(@class, 'itemList')]");

        foreach ($els as $el) {
            $lis = $el->getElementsByTagName('li');
            foreach ($lis as $li) {
                $dpsWeb[] = $this->__normalize($li->textContent);
            }
        }

        $common = $this->__intersect($dpNames, $dpsWeb, $dps->data);

        var_dump($common);
    }

    private function __intersect(array $arr1, array $arr2, array $lookup): array
    {
        $flipped1 = array_flip($arr1);
        $flipped2 = array_flip($arr2);
        $common_values_with_flipped_indices = array_intersect_key($flipped1, $flipped2);

        $common_indices = array_values($common_values_with_flipped_indices);

        return array_map(function ($index) use ($lookup) {
            return $lookup[$index];
        }, $common_indices);
    }

    private function __normalize(string $str): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', mb_strtolower(trim($str)));
    }
}
