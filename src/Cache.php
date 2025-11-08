<?php

namespace App;

use App\Cache\ICache;
use App\Models\Api\Response;
use App\Wrappers\Env;

class Cache implements ICache
{
    private ?ICache $engine = null;

    public function __construct()
    {
        $cache = Env::api_cache();
        $this->engine = $cache?->engine() ?? null;
    }

    public function isEnabled(): bool
    {
        return $this->engine !== null;
    }

    public function get(string $cache_key, bool $isJson): ?Response
    {
        return $this->isEnabled() ? $this->engine->get($cache_key, $isJson) : null;
    }

    public function exists(string $cache_key): bool
    {
        return $this->isEnabled() ? $this->engine->exists($cache_key) : false;
    }

    public function set(string $cache_key, string $data, int $timeout = 86400): void
    {
        if ($this->isEnabled()) {
            $this->engine->set($cache_key, $data, $timeout);
        }
    }
}
