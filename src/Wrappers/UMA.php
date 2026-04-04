<?php

namespace App\Wrappers;

use App\Models\Exclusion;
use UMA\Api;
use UMA\Options;

use function count;

class UMA
{
    public static function api(): Api
    {
        $cache = Env::api_cache();
        $options = new Options(cache: $cache?->engine());
        return new Api($options);
    }

    public static function isExcluded(string $idnc): bool
    {
        return Exclusion::where('idnc', '=', $idnc)->exists();
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
