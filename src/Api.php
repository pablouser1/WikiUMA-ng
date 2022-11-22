<?php
namespace App;

use App\Cache\Cache;
use App\Cache\RedisCache;

class Api {
    const BASE_URL = "https://duma.uma.es/api/appuma";
    private ?Cache $cacheEngine = null;

    function __construct() {
        // Cache config
        if (isset($_ENV['API_CACHE'])) {
            switch ($_ENV['API_CACHE']) {
                case 'redis':
                    if (!(isset($_ENV['REDIS_URL']) || isset($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']))) {
                        throw new \Exception('You need to set REDIS_URL or REDIS_HOST and REDIS_PORT to use Redis Cache!');
                    }

                    if (isset($_ENV['REDIS_URL'])) {
                        $url = parse_url($_ENV['REDIS_URL']);
                        $host = $url['host'];
                        $port = intval($url['port']);
                        $password = $url['pass'] ?? null;
                    } else {
                        $host = $_ENV['REDIS_HOST'];
                        $port = intval($_ENV['REDIS_PORT']);
                        $password = isset($_ENV['REDIS_PASSWORD']) ? $_ENV['REDIS_PASSWORD'] : null;
                    }
                    $this->cacheEngine = new RedisCache($host, $port, $password);
                    break;
            }
        }
    }

    public function centros(): ?array {
        return $this->__handleRequest('/centros/listado/');
    }

    public function titulaciones(int $id): ?array {
        return $this->__handleRequest("/centros/titulaciones/$id/");
    }

    public function plan(int $id): ?object {
        return $this->__handleRequest("/plan/$id/");
    }

    public function asignatura(int $id, int $plan_id): ?object {
        return $this->__handleRequest("/asignatura/$id/$plan_id/");
    }

    public function profesor(string $email): ?object {
        return $this->__handleRequest("/profesor/$email/");
    }

    private function __handleRequest(string $endpoint) {
        $key = str_replace('/', '-', substr($endpoint, 1, -1));

        return $this->__hasCache($key) ? $this->__getCache($key) : $this->__send($endpoint, $key);
    }

    private function __send(string $endpoint, string $key) {
        $version = \Composer\InstalledVersions::getVersion('pablouser1/wikiuma-ng');
        $ch = curl_init(self::BASE_URL . $endpoint);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "WikiUMA-ng/$version (https://github.com/pablouser1/WikiUMA-ng)"
        ]);

        $data = curl_exec($ch);
        $errno = curl_errno($ch);
        curl_close($ch);
        if (!$errno && $data) {
            $this->__setCache($key, $data);
            return json_decode($data, false);
        }
        return null;
    }

    private function __hasCache(string $key): bool {
        return $this->cacheEngine && $this->cacheEngine->exists($key);
    }

    private function __getCache(string $key) {
        return $this->cacheEngine->get($key);
    }

    private function __setCache(string $key, string $data) {
        if ($this->cacheEngine) $this->cacheEngine->set($key, $data);
    }
}
