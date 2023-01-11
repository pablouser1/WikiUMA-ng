<?php
namespace App\Cache;

use App\Models\Response;

interface ICache {
    public function get(string $cache_key, bool $isJson): ?Response;
    public function exists(string $cache_key): bool;
    public function set(string $cache_key, string $data, int $timeout = 3600): void;
}
