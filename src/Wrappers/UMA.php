<?php

namespace App\Wrappers;

use UMA\Api;
use UMA\Options;

class UMA
{
    public static function api(): Api
    {
        $cache = Env::api_cache();
        $options = new Options(cache: $cache?->engine());
        return new Api($options);
    }
}
