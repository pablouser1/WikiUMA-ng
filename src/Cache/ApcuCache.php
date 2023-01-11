<?php
namespace App\Cache;

use App\Models\Response;

class ApcuCache implements ICache {
    function __construct() {
        if (!(extension_loaded('apcu') && apcu_enabled())) {
            throw new \Exception('APCu not enabled');
        }
    }

    public function get(string $cache_key, bool $isJson): ?Response {
        $data = apcu_fetch($cache_key);
        if ($data) {
            return new Response(200, $data, $isJson);
        }
        return null;
    }

    public function exists(string $cache_key): bool {
        return apcu_exists($cache_key);
    }

    public function set(string $cache_key, string $data, int $timeout = 3600): void {
        apcu_store($cache_key, $data, $timeout);
    }
}
