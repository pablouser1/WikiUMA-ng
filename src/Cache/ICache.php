<?php
namespace App\Cache;

use App\Models\Api\Response;

interface ICache {
    /**
     * Get response from cache.
     */
    public function get(string $cache_key, bool $isJson): ?Response;

    /**
     * Check if response exists in cache.
     */
    public function exists(string $cache_key): bool;

    /**
     * Write response to cache.
     */
    public function set(string $cache_key, string $data, int $timeout = 3600): void;
}
