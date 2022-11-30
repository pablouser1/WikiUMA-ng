<?php
namespace App;

use App\Cache\Cache;
use App\Cache\RedisCache;
use App\Helpers\Misc;

class Api {
    const BASE_API = "https://duma.uma.es/api/appuma";
    const BASE_WEB = "https://duma.uma.es/duma";
    private ?Cache $cacheEngine = null;
    private string $csrfFile;
    private string $version;

    function __construct() {
        $this->csrfFile = sys_get_temp_dir() . '/wikiuma.txt';
        $this->version = \Composer\InstalledVersions::getVersion('pablouser1/wikiuma-ng');
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
        $key = 'centros';
        return $this->__handleRequest('/centros/listado/', $key);
    }

    public function titulaciones(int $id): ?array {
        return $this->__handleRequest("/centros/titulaciones/$id/", "titulaciones-" . $id);
    }

    public function plan(int $id): ?object {
        return $this->__handleRequest("/plan/$id/", "plan-" . $id);
    }

    public function asignatura(int $id, int $plan_id): ?object {
        return $this->__handleRequest("/asignatura/$id/$plan_id/", 'asignatura-' . $id);
    }

    public function profesor(string $email): ?object {
        return $this->__handleRequest("/profesor/$email/", 'profesor-' . $email);
    }

    public function profesorWeb(string $idnc): string {
        $email = '';
        $html = $this->__handleRequest('/buscador/persona/' . $idnc . '/', "", [], [], "", false);
        $doc = Misc::parseHTML($html);
        if ($doc) {
            $xpath = new \DOMXpath($doc);
            $elements = $xpath->query("/html/body/div[4]/div[2]/div[2]");
            if ($elements) {
                $div = $elements->item(0);
                $email = $div->textContent;
            }
        }
        return $email;
    }

    public function buscar(string $nombre, string $apellido_1, string $apellido_2): array {
        $results = [];
        $csrf = $this->__getCsrf();
        $headers = [
            "Referer: https://duma.uma.es/duma/buscador/"
        ];
        $cookies = "csrftoken=" . $csrf;

        $html = $this->__handleRequest('/buscador/persona/', '', [
            "csrfmiddlewaretoken" => $csrf,
            "pas" => "on",
            "pdi" => "on",
            "nombre" => $nombre,
            "apellido_1" => $apellido_1,
            "apellido_2" => $apellido_2,
            "email" => "",
            "telefono" => "",
            "centro" => "",
            "departamento" => "",
            "general" => ""
        ], $headers, $cookies, false);

        $doc = Misc::parseHTML($html);

        if ($doc) {
            $h4s = $doc->getElementsByTagName('h4');
            foreach ($h4s as $h4) {
                // Take second child (a)
                $a = $h4->childNodes->item(2);
                if ($a) {
                    $url = $a->getAttribute('href');
                    if ($url) {
                        $results[] = (object) [
                            'name' => $a->textContent,
                            'idnc' => basename($url)
                        ];
                    }
                }
            }
        }

        return $results;
    }

    private function __handleRequest(string $endpoint, string $key = "", array $body = [], array $headers = [], string $cookies = "", bool $isJson = true) {
        return $isJson && $this->__hasCache($key) ? $this->__getCache($key) : $this->__send($endpoint, $key, $body, $headers, $cookies, $isJson);
    }

    private function __send(string $endpoint, string $key, array $body = [], array $headers = [], string $cookies = "", bool $isJson = true) {
        $base = $isJson ? self::BASE_API : self::BASE_WEB;

        $options = [
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "WikiUMA-ng/{$this->version} (https://github.com/pablouser1/WikiUMA-ng)"

        ];

        $url = $base . $endpoint;

        if (!empty($body)) {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = http_build_query($body);
        }

        if (!empty($headers)) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        if ($cookies) {
            $options[CURLOPT_COOKIE] = $cookies;
        }

        $ch = curl_init($url);

        curl_setopt_array($ch, $options);

        $data = curl_exec($ch);
        $errno = curl_errno($ch);
        curl_close($ch);
        if (!$errno && $data) {
            if ($isJson) {
                $this->__setCache($key, $data);
            }
            return $isJson ? json_decode($data, false) : $data;
        }
        return null;
    }

    private function __getCsrf(): ?string {
        if (is_file($this->csrfFile)) {
            return file_get_contents($this->csrfFile);
        }

        $ch = curl_init(self::BASE_WEB . '/buscador/persona/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_USERAGENT => "WikiUMA-ng/{$this->version} (https://github.com/pablouser1/WikiUMA-ng)"
        ]);
        $result = curl_exec($ch);
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        if (isset($cookies['csrftoken'])) {
            file_put_contents($this->csrfFile, $cookies['csrftoken']);
            return $cookies['csrftoken'];
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
