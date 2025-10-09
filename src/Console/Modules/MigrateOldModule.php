<?php

namespace App\Console\Modules;

use App\Api;
use App\Console\Base;
use App\Console\IBase;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Misc;
use App\Wrappers\Storage;
use League\CLImate\CLImate;

/**
 * Migrate from old WikiUMA (rip).
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
        [
            'name' => 'Link db users with email manually',
            'runner' => [self::class, 'dbToEmailManual'],
        ],
        [
            'name' => 'Link email to idnc',
            'runner' => [self::class, 'emailToIdnc'],
        ],
        [
            'name' => 'Build reviews JSON for mass-import',
            'runner' => [self::class, 'buildReviewsJSON'],
        ],
        [
            'name' => 'Import reviews from JSON',
            'runner' => [self::class, 'importReviews'],
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

    /**
     * {@inheritdoc}
     */
    public function entrypoint(): void
    {
        $this->cli->bold()->out('Migrations');
        $this->radio(self::OPTIONS);
    }

    /**
     * Get teachers' names from db and attempt to
     * relate them to data found on DUMA.
     */
    public function dbToEmail(): void
    {
        $teachersDuma = $this->__buildTeachersList();
        if ($teachersDuma === null) {
            return;
        }

        $teachersDumaProcessed = array_map(function (object $teacher) {
            $teacher->displayName = $this->__normalize($teacher->displayName);
            return $teacher;
        }, $teachersDuma);

        $teachersDb = $this->__getTeachersDb();
        if ($teachersDb === null) {
            $this->cli->backgroundRed()->error('Local db error');
            return;
        }

        $relations = [];
        $failed = [];
        foreach ($teachersDb as $teacherDb) {
            $match = null;
            $i = 0;
            while ($match === null && $i < count($teachersDumaProcessed)) {
                $teacherDumaProcessed = $teachersDumaProcessed[$i];

                if ($teacherDb->name === $teacherDumaProcessed->displayName) {
                    $match = $teacherDumaProcessed;
                }
                $i++;
            }

            if ($match !== null && $match->irisMailMainAddress !== '') {
                $relations[$teacherDb->id] = $match->irisMailMainAddress;
            } else {
                $failed[] = $teacherDb;
            }
        }

        Storage::save('teachers.json', json_encode($teachersDuma, JSON_PRETTY_PRINT));
        Storage::save('relations-email.json', json_encode($relations, JSON_PRETTY_PRINT));
        Storage::save('failed-email.json', json_encode($failed, JSON_PRETTY_PRINT));

        $this->cli->out('Teachers linked: ' . count($relations));
        $this->cli->out('Failed: ' . count($failed));
        $this->cli->out('DUMA teachers saved: ' . count($teachersDuma));
    }

    /**
     * Used for teachers that couldn't be linked automatically
     * on last step.
     * Show names one by one and write email manually.
     */
    public function dbToEmailManual(): void
    {
        $failed = json_decode(Storage::get('failed-email.json'));
        if ($failed === false) {
            $this->cli->backgroundRed()->error('Could not get failed json from last step');
            return;
        }

        $relationsEmail = json_decode(Storage::get('relations-email.json'), true);
        if ($relationsEmail === false) {
            $this->cli->backgroundRed()->error('Could not get json from last step');
            return;
        }

        $newLinks = [];

        foreach ($failed as $link) {
            $this->cli->out($link->name);
            $in = $this->cli->input("Write email (empty for skip):");
            $email = $in->prompt();
            if ($email !== '') {
                $newLinks[$link->id] = $email;
            }
        }



        $mergedLinks = $relationsEmail + $newLinks;

        Storage::save('relations-email-withmanual.json', json_encode($mergedLinks, JSON_PRETTY_PRINT));
    }

    /**
     * Relate email to idnc.
     */
    public function emailToIdnc(): void
    {
        $relationsEmail = json_decode(Storage::get('relations-email.json'));
        if ($relationsEmail === false) {
            $this->cli->backgroundRed()->error('Could not get json from last step');
            return;
        }

        $relationsIdnc = [];
        $failed = [];

        foreach ($relationsEmail as $id => $email) {
            $profesor = $this->api->profesor($email);
            if (!$profesor->success) {
                $failed[] = $email;
            }

            $relationsIdnc[$id] = $profesor->data->idnc;
        }

        Storage::save('relations-idnc.json', json_encode($relationsIdnc, JSON_PRETTY_PRINT));
        Storage::save('failed-idnc.json', json_encode($failed, JSON_PRETTY_PRINT));

        $this->cli->out('IDNCs obtained: ' . count($relationsIdnc));
        $this->cli->out('Failed: ' . count($failed));
    }

    /**
     * Write JSON with all importable reviews.
     */
    public function buildReviewsJSON(): void
    {
        $relationsIdnc = json_decode(Storage::get('relations-idnc.json'), true);
        if ($relationsIdnc === false) {
            $this->cli->backgroundRed()->error('Could not get json from last step');
            return;
        }

        $reviews = $this->__getReviewsDbByIds($relationsIdnc);
        if ($reviews === null) {
            $this->cli->backgroundRed()->error('Could not get reviews from db');
            return;
        }

        Storage::save('reviews.json', json_encode($reviews, JSON_PRETTY_PRINT));
    }

    /**
     * Import `reviews.json`
     */
    public function importReviews(): void
    {
        $reviews = json_decode(Storage::get('reviews.json'), true);
        if ($reviews === false) {
            $this->cli->backgroundRed()->error('Could not get json from last step');
            return;
        }

        Review::insert($reviews);
    }

    /**
     * Get all teachers from all departments in ETSII and ETSIT.
     */
    private function __buildTeachersList(): ?array
    {
        $dps = $this->api->departamentos('a02');
        if (!$dps->success) {
            $this->cli->backgroundRed()->error('Could not get departments');
            return null;
        }
        $dpNames = array_map(fn($dp) => $this->__normalize($dp->nombre), $dps->data);

        $dpsInformatica = $this->__getDepartamentosInformatica();
        if ($dpsInformatica === null) {
            $this->cli->backgroundRed()->error('Could not get departments from website');
            return null;
        }

        $dpsTeleco = $this->__getDepartamentosTeleco();
        if ($dpsTeleco === null) {
            $this->cli->backgroundRed()->error('Could not get departments from website');
            return null;
        }

        $dpsWeb = array_unique(array_merge($dpsInformatica, $dpsTeleco));

        $common = $this->__intersect($dpNames, $dpsWeb, $dps->data);

        $teachersDuma = [];
        foreach ($common as $dp) {
            $cod = $dp->codigo;

            $sections = $this->api->departamentos($cod);
            if (!$sections->success) {
                $this->cli->backgroundRed()->error("Could not get sections of $cod");
                return null;
            }

            $areaCod = $this->__findArea($sections->data);

            $area = $this->api->departamentos($areaCod);
            if (!$sections->success) {
                $this->cli->backgroundRed()->error("Could not get area content of $areaCod");
                return null;
            }

            foreach ($area->data as $item) {
                $personal = $this->api->personal($item->codigo);
                if (!$personal->success) {
                    $this->cli->backgroundRed()->error("Could not get area content of {$item->codigo}");
                    return null;
                }

                foreach ($personal->data as $teacher) {
                    $teachersDuma[] = $teacher;
                }
            }
        }

        return $teachersDuma;
    }

    /**
     * Get useful section of department.
     */
    private function __findArea(array $sections): ?string
    {
        $i = 0;
        $val = null;

        while ($val === null && $i < count($sections)) {
            $section = $sections[$i];
            if ($section->nombre === 'ÁREA') {
                $val = $section->codigo;
            }

            $i++;
        }

        return $val;
    }

    /**
     * Get all teachers from backup db.
     */
    private function __getTeachersDb(): ?array
    {
        $teachers = [];
        $res = $this->db->query("SELECT * FROM profesor");
        if ($res === false) {
            return null;
        }

        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $teachers[] = (object) [
                'id' => $row['ID'],
                'name' => $this->__normalize($row['Nombre']),
            ];
        }

        return $teachers;
    }

    /**
     * Get reviews from linked teachers.
     */
    private function __getReviewsDbByIds(array $relationsIdnc): ?array
    {
        $reviews = [];
        $idsStr = implode(',', array_keys($relationsIdnc));
        $res = $this->db->query("SELECT * FROM valoraciones WHERE ID_Profesor IN ($idsStr)");
        if ($res === false) {
            return null;
        }

        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $reviews[] = (object) [
                'created_at' => $row['Fecha'],
                'target' => $relationsIdnc[$row['ID_Profesor']],
                'type' => ReviewTypesEnum::TEACHER,
                'username' => $row['Nick'] !== "" ? trim($row['Nick']) : null,
                'note' => $row['Valoracion'],
                'message' => trim($row['Comentario']),
                'votes' => $row['VotosPositivos'] - $row['VotosNegativos'],
            ];
        }

        return $reviews;
    }

    private function __getDepartamentosInformatica(): ?array
    {
        $ch = curl_init('https://www.uma.es/etsi-informatica/info/10610/departamentos/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_USERAGENT => self::USER_AGENT,
        ]);

        $result = curl_exec($ch);
        if ($result === false) {
            return null;
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

        return $dpsWeb;
    }

    private function __getDepartamentosTeleco(): ?array
    {
        $ch = curl_init('https://www.uma.es/etsi-de-telecomunicacion/info/42412/departamentos/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_USERAGENT => self::USER_AGENT,
        ]);

        $result = curl_exec($ch);
        if ($result === false) {
            return null;
        }

        $dpsWeb = [];

        $dom = Misc::parseHTML($result);
        $xpath = new \DOMXPath($dom);
        $el = $xpath->query("/html/body/div[6]/div[2]/div[1]/p[2]");

        $anchors = $el->item(0)->getElementsByTagName('a');

        foreach ($anchors as $a) {
            $dpsWeb[] = $this->__normalize($a->textContent);
        }

        return $dpsWeb;
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
        return iconv('UTF-8', 'ASCII//TRANSLIT', str_replace('-', ' ', mb_strtolower(trim($str))));
    }
}
