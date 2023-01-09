<?php
namespace App\Cache;

interface Cache {
    public function get(string $cache_key);
    public function exists(string $cache_key): bool;
    public function set(string $cache_key, string $data, int $timeout = 3600);
}
