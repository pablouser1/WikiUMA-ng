<?php

namespace App\Cache;

use App\Models\Api\Response;

/**
 * Cache using JSON files. Should only be used when debugging!
 */
class JSONCache implements ICache
{
    private string $cache_path;

    public function __construct()
    {
        if (isset($_ENV['API_CACHE_JSON']) && !empty($_ENV['API_CACHE_JSON'])) {
            $this->cache_path = $_ENV['API_CACHE_JSON'];
        } else {
            $this->cache_path = sys_get_temp_dir() . '/wikiuma_api';
            if (!is_dir($this->cache_path)) {
                $created = mkdir($this->cache_path, 0777, true);
                if (!$created) {
                    throw new \Exception('Error creating cache folder');
                }
            }
        }
    }

    public function get(string $cache_key, bool $isJson): ?Response
    {
        $filename = $this->cache_path . '/' . $cache_key . '.json';
        if (is_file($filename)) {
            $json_string = file_get_contents($filename);
            return new Response(200, $json_string, $isJson);
        }
        return null;
    }

    public function exists(string $cache_key): bool
    {
        $filename = $this->cache_path . '/' . $cache_key . '.json';
        return is_file($filename);
    }

    public function set(string $cache_key, string $data, int $timeout = 3600): void
    {
        file_put_contents($this->cache_path . '/' . $cache_key . '.json', $data);
    }
}
