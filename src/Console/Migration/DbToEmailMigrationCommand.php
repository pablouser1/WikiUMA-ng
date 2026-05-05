<?php

namespace App\Console\Migration;

use App\Wrappers\Misc;
use App\Wrappers\Storage;
use DOMXPath;

use function count;
use function array_merge;

class DbToEmailMigrationCommand extends BaseMigration
{
    private const string USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36';

    public function __construct()
    {
        parent::__construct(
            'migration:db2email',
            'Get teachers\' names from db and attempt to relate them to data found on DUMA',
        );
    }

    /**
     * @return int Return code
     */
    public function execute()
    {
        $w = $this->app()->io()->writer();

        $teachersDuma = $this->__buildTeachersList();
        if ($teachersDuma === null) {
            return 1;
        }

        $teachersDumaProcessed = array_map(function (object $teacher) {
            $teacher->displayName = $this->__normalize($teacher->displayName);
            return $teacher;
        }, $teachersDuma);

        $teachersDb = $this->__getTeachersDb();
        if ($teachersDb === null) {
            $w->error('Local db error');
            return 1;
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

        $w->info('Teachers linked: ' . count($relations), true);
        $w->info('Failed: ' . count($failed), true);
        $w->info('DUMA teachers saved: ' . count($teachersDuma), true);

        return 0;
    }

    /**
     * Get all teachers from all departments in ETSII and ETSIT.
     */
    private function __buildTeachersList(): ?array
    {
        $w = $this->app()->io()->writer();
        $api = $this->api();
        $dps = $api->departamentos('a02');
        if (!$dps->success) {
            $w->error('Could not get departments', true);
            return null;
        }
        $dpNames = array_map(fn($dp) => $this->__normalize($dp->nombre), $dps->data);

        $dpsInformatica = $this->__getDepartamentosInformatica();
        if ($dpsInformatica === null) {
            $w->error('Could not get departments from website');
            return null;
        }

        $dpsTeleco = $this->__getDepartamentosTeleco();
        if ($dpsTeleco === null) {
            $w->error('Could not get departments from website');
            return null;
        }

        $dpsWeb = array_unique(array_merge($dpsInformatica, $dpsTeleco));

        $common = $this->__intersect($dpNames, $dpsWeb, $dps->data);

        $teachersDuma = [];
        foreach ($common as $dp) {
            $cod = $dp->codigo;

            $sections = $api->departamentos($cod);
            if (!$sections->success) {
                $w->error("Could not get sections of $cod");
                return null;
            }

            $areaCod = $this->__findArea($sections->data);

            $area = $api->departamentos($areaCod);
            if (!$sections->success) {
                $w->error("Could not get area content of $areaCod");
                return null;
            }

            foreach ($area->data as $item) {
                $personal = $api->personal($item->codigo);
                if (!$personal->success) {
                    $w->error("Could not get area content of {$item->codigo}");
                    return null;
                }

                foreach ($personal->data as $teacher) {
                    $teachersDuma[] = $teacher;
                }
            }
        }

        return $teachersDuma;
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
        $xpath = new DOMXPath($dom);
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
        $xpath = new DOMXPath($dom);
        $el = $xpath->query('/html/body/div[6]/div[2]/div[1]/p[2]');

        $anchors = $el->item(0)->getElementsByTagName('a');

        foreach ($anchors as $a) {
            $dpsWeb[] = $this->__normalize($a->textContent);
        }

        return $dpsWeb;
    }

    /**
     * Get all teachers from backup db.
     */
    private function __getTeachersDb(): ?array
    {
        $db = $this->db();
        $teachers = [];
        $res = $db->query('SELECT * FROM profesor');
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

    private function __normalize(string $str): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', str_replace('-', ' ', mb_strtolower(trim($str))));
    }
}
