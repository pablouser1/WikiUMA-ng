<?php

namespace App\Wrappers;

class Misc
{
    public static function parseHTML(?string $html): ?\DOMDocument
    {
        if ($html) {
            $doc = new \DOMDocument();
            $success = @$doc->loadHTML($html);
            if ($success) {
                return $doc;
            }
        }
        return null;
    }

    public static function planAsignaturaSplit(string $str): ?array
    {
        $arr = explode(';', $str);
        if (count($arr) === 2) {
            return $arr;
        }

        return null;
    }

    public static function planAsignaturaJoin(string $plan_id, string $asig_id): string
    {
        return $plan_id . ';' . $asig_id;
    }
}
