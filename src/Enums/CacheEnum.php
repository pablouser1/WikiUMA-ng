<?php

namespace App\Enums;

use App\Wrappers\Env;
use chillerlan\SimpleCache\APCUCache;
use chillerlan\SimpleCache\CacheOptions;
use chillerlan\SimpleCache\FileCache;
use chillerlan\SimpleCache\RedisCache;
use Psr\SimpleCache\CacheInterface;

/**
 * Enumerate all avilable cache engines.
 */
enum CacheEnum: string
{
    case FILE = "file";
    case APCU = "apcu";
    case REDIS = "redis";

    public function engine(): ?CacheInterface
    {
        return match ($this) {
            CacheEnum::FILE => new FileCache(new CacheOptions(['cacheFilestorage' => __DIR__.'/../../storage/data'])),
            CacheEnum::APCU => new APCUCache(),
            CacheEnum::REDIS => new RedisCache(Env::redis()),
            default => null,
        };
    }
}
