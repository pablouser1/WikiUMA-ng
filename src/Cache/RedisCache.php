<?php

namespace App\Cache;

use App\Models\Api\Response;


/**
 * Cache using Redis. Recommended for general usage.
 */
class RedisCache implements ICache
{
    private \Redis $client;

    public function __construct(string $host, int $port, ?string $password)
    {
        $this->client = new \Redis();
        if (!$this->client->connect($host, $port)) {
            throw new \Exception('REDIS: Could not connnect to server');
        }
        if ($password) {
            if (!$this->client->auth($password)) {
                throw new \Exception('REDIS: Could not authenticate');
            }
        }
    }

    public function __destruct()
    {
        $this->client->close();
    }

    public function get(string $cache_key, bool $isJson): ?Response
    {
        $data = $this->client->get($cache_key);
        if ($data) {
            return new Response(200, $data, $isJson);
        }
        return null;
    }

    public function exists(string $cache_key): bool
    {
        return $this->client->exists($cache_key);
    }

    public function set(string $cache_key, string $data, int $timeout = 3600): void
    {
        $this->client->set($cache_key, $data, $timeout);
    }
}
