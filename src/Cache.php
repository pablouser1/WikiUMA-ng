<?php

namespace App;

use App\Cache\ApcuCache;
use App\Cache\ICache;
use App\Cache\JSONCache;
use App\Cache\RedisCache;
use App\Enums\CacheEnum;
use App\Models\Api\Response;
use App\Wrappers\Env;

class Cache implements ICache
{
    private ?ICache $engine = null;

    public function __construct()
    {
        // Cache config
        $cache = Env::api_cache();
        if ($cache !== null) {
            switch ($cache) {
                case CacheEnum::JSON:
                    // ONLY FOR DEBUGGING
                    $this->engine = new JSONCache();
                    break;
                case CacheEnum::APCU:
                    // For small setups
                    $this->engine = new ApcuCache();
                    break;
                case CacheEnum::REDIS:
                    // RECOMMENDED
                    $redis = Env::redis();
                    $this->engine = new RedisCache($redis['host'], $redis['port'], $redis['password']);
                    break;
            }
        }
    }

    public function isEnabled(): bool
    {
        return $this->engine !== null;
    }

    public function get(string $cache_key, bool $isJson): ?Response {
        return $this->isEnabled() ? $this->engine->get($cache_key, $isJson) : null;
    }

    public function exists(string $cache_key): bool
    {
        return $this->isEnabled() ? $this->engine->exists($cache_key) : false;
    }

    public function set(string $cache_key, string $data, int $timeout = 3600): void
    {
        if ($this->isEnabled()) {
            $this->engine->set($cache_key, $data, $timeout);
        }
    }
}
