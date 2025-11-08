<?php

namespace App\Cache;

use App\Models\Api\Response;
use App\Wrappers\Env;

/**
 * Cache using JSON files. Should only be used when debugging!
 */
class JSONCache implements ICache
{
    private string $cachePath;

    /**
     * @todo Add custom exception
     */
    public function __construct()
    {
        $this->cachePath = Env::api_cache_json();
        if (!is_dir($this->cachePath)) {
            $created = mkdir($this->cachePath, 0777, true);
            if (!$created) {
                throw new \RuntimeException('Error creating cache folder');
            }
        }
    }

    public function get(string $cache_key, bool $isJson): ?Response
    {
        if ($this->exists($cache_key)) {
            $json_string = file_get_contents($this->buildFilename($cache_key));
            return new Response(200, $json_string, $isJson);
        }
        return null;
    }

    public function exists(string $cache_key): bool
    {
        return is_file($this->buildFilename($cache_key));
    }

    public function set(string $cache_key, string $data, int $timeout = 86400): void
    {
        file_put_contents($this->buildFilename($cache_key), $data);
    }

    private function buildFilename(string $cache_key): string
    {
        return $this->cachePath . '/' . $cache_key . '.json';
    }
}
