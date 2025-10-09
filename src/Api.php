<?php

namespace App;

use App\Constants\App;
use App\Wrappers\Misc;
use App\Models\Api\Response;

/**
 * Wrapper for all UMA requests.
 */
class Api
{
    private const string BASE_API = "https://duma.uma.es/api/appuma";
    private const string BASE_WEB = "https://duma.uma.es/duma";
    private Cache $cache;
    private string $csrfFile;
    private string $version;

    public function __construct(?Cache $cache = null)
    {
        $this->cache = $cache ?? new Cache();
        $this->csrfFile = sys_get_temp_dir() . '/uma_csrf.txt'; // Usado después en búsquedas de profesores
        $this->version = App::VERSION;
    }

    public function centros(): Response
    {
        return $this->__handleRequest('/centros/listado/', 'centros');
    }

    /**
     * Titulaciones a partir del id del centro
     */
    public function titulaciones(int $id): Response
    {
        return $this->__handleRequest("/centros/titulaciones/$id/", "titulaciones|" . $id);
    }

    /**
     * Plan a partir de su id
     */
    public function plan(int $id): Response
    {
        return $this->__handleRequest("/plan/$id/", "plan|" . $id);
    }

    /**
     * Asignatura usando el ID de la asignatura y el ID del plan asociado
     *
     * NOTA: El id de plan debe estar presente aunque puede ser cualquier valor
     */
    public function asignatura(int $asignatura_id, int $plan_id): Response
    {
        return $this->__handleRequest("/asignatura/$asignatura_id/$plan_id/", 'asignatura|' . $asignatura_id);
    }

    /**
     * Profesor usando su correo electrónico
     */
    public function profesor(string $email): Response
    {
        return $this->__handleRequest("/profesor/$email/", 'profesor|' . $email);
    }

    /**
     * Convierte un idnc a email haciendo scraping en la web
     */
    public function profesorWeb(string $idnc): Response
    {
        $email = '';
        $res = $this->__handleRequest('/buscador/persona/' . $idnc . '/', "", [], [], "", false);
        if (!$res->success) {
            return $res;
        }

        $doc = Misc::parseHTML($res->data);
        if ($doc) {
            $xpath = new \DOMXpath($doc);
            $elements = $xpath->query("/html/body/div[4]/div[2]/div[2]");
            if ($elements !== false && $elements->count() > 0) {
                $div = $elements->item(0);

                // Los correos electrónicos están separados con <br>
                // Extraemos el primero disponible
                $innerHtml = Misc::DOMInnerHTML($div);

                $emailsUnfiltered = array_map(fn (string $email) => trim($email), explode('<br>', $innerHtml));
                $emails = array_filter($emailsUnfiltered, fn (string $email) => !empty($email));
                $email = $emails[0];
            }
        }

        if ($email) {
            return new Response(200, (object) ['email' => $email], false);
        }
        return new Response(502, null);
    }

    /**
     * Hacer búsqueda por DUMA vía web scraping.
     */
    public function buscar(string $nombre, string $apellido_1, string $apellido_2): Response
    {
        $results = [];
        $csrf = $this->__getCsrf();
        $headers = [
            "Referer: https://duma.uma.es/duma/buscador/",
        ];

        $cookies = "csrftoken=" . $csrf;

        $res = $this->__handleRequest('/buscador/persona/', '', [
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

        if (!$res->success) {
            return $res;
        }

        $doc = Misc::parseHTML($res->data);
        if ($doc) {
            // Get all h4 in the doc
            $h4s = $doc->getElementsByTagName('h4');
            foreach ($h4s as $h4) {
                // Take second child (a)
                $a = $h4->childNodes->item(2);
                if ($a) {
                    $url = $a->attributes?->getNamedItem('href')?->value;
                    if ($url) {
                        $results[] = (object) [
                            'name' => mb_convert_encoding($a->textContent, 'ISO-8859-1'), // Sin el mb_convert_encoding los caractéres especiales salen mal
                            'idnc' => basename($url)
                        ];
                    }
                }
            }
        }

        return new Response(200, $results, false);
    }

    public function departamentos(string $codigo): Response
    {
        return $this->__handleRequest("/departamentos/listado/$codigo/", "departamentos|$codigo");
    }

    public function personal(string $codigo): Response
    {
        return $this->__handleRequest("/departamentos/personal/$codigo/", "departamentos|$codigo");
    }

    private function __handleRequest(string $endpoint, string $key = "", array $body = [], array $headers = [], string $cookies = "", bool $isJson = true): Response
    {
        if ($key !== '' && $this->cache->exists($key)) {
            // Use cache
            return $this->cache->get($key, $isJson);
        }

        // Make request
        return $this->__send($endpoint, $key, $body, $headers, $cookies, $isJson);
    }

    private function __send(string $endpoint, string $key, array $body = [], array $headers = [], string $cookies = "", bool $isJson = true): Response
    {
        $base = $isJson ? self::BASE_API : self::BASE_WEB;

        $options = [
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $this->__getUserAgent(),
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
        $error = curl_errno($ch);
        $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        if (!$error) {
            // Request sent
            $res = new Response($code, $data, $isJson);
            if ($res->success && $key !== '') {
                $this->cache->set($key, $data);
            }
            return $res;
        }
        return new Response(502, null, $isJson);
    }

    private function __getCsrf(): ?string
    {
        // Get csrf token if it already exists
        if (is_file($this->csrfFile)) {
            return file_get_contents($this->csrfFile);
        }

        $ch = curl_init(self::BASE_WEB . '/buscador/persona/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_USERAGENT => $this->__getUserAgent(),
        ]);

        $result = curl_exec($ch);

        if ($result !== false) {
            // Extract cookies
            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
            $cookies = [];
            foreach ($matches[1] as $item) {
                parse_str($item, $cookie);
                $cookies = array_merge($cookies, $cookie);
            }

            // Write csrf token to tmp
            if (isset($cookies['csrftoken'])) {
                file_put_contents($this->csrfFile, $cookies['csrftoken']);
                return $cookies['csrftoken'];
            }
        }

        return null;
    }

    private function __getUserAgent(): string
    {
        $pkgName = App::PACKAGE_NAME;
        return "WikiUMA-ng/{$this->version} (https://github.com/$pkgName";
    }
}
