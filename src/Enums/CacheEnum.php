<?php

namespace App\Enums;

use App\Cache\ApcuCache;
use App\Cache\ICache;
use App\Cache\JSONCache;
use App\Cache\RedisCache;
use App\Wrappers\Env;

/**
 * Enumerate all avilable cache engines.
 */
enum CacheEnum: string
{
    case JSON = "json";
    case APCU = "apcu";
    case REDIS = "redis";

    public function engine(): ?ICache
    {
        $redis = Env::redis();
        return match ($this) {
            CacheEnum::JSON => new JSONCache(),
            CacheEnum::APCU => new ApcuCache(),
            CacheEnum::REDIS => new RedisCache($redis['host'], $redis['port'], $redis['password']),
            default => null,
        };
    }
}
