<?php
namespace App\Helpers;

use App\Constants\Links;

class Wrappers {
    static public function db(): \PDO {
        $driver = Misc::env('DB_DRIVER', 'mysql');
        $host = Misc::env('DB_HOST', 'localhost');
        $port = Misc::env('DB_PORT', 3306);
        $db = Misc::env('DB_NAME', 'umabot');
        $username = Misc::env('DB_USERNAME', '');
        $password = Misc::env('DB_PASSWORD', '');
        $dns = $driver .
        ':host=' . $host .
        ';port=' . $port .
        ';dbname=' . $db . ';charset=utf8mb4';
        return new \PDO($dns, $username, $password);
    }

    /**
     * Render template with Plates
     */
    static public function plates(string $view, array $data = []): void {
        $engine = new \League\Plates\Engine(__DIR__ . '/../../templates');
        $engine->registerFunction('url', function(string $endpoint, array $query = []): string {
            return Misc::url($endpoint, $query);
        });
        $engine->registerFunction('current_url', function(): string {
            // https://www.javatpoint.com/how-to-get-current-page-url-in-php
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $url = "https://";
            else
                $url = "http://";
            // Append the host(domain name, ip) to the URL.
            $url .= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            $url .= $_SERVER['REQUEST_URI'];
            return $url;
        });
        $engine->registerFunction('version', function (): string {
            return \Composer\InstalledVersions::getVersion('pablouser1/wikiuma-ng');
        });
        $engine->registerFunction('links', function (): array {
            return Links::list;
        });
        $engine->registerFunction('isAdmin', function (): bool {
            return Misc::isLoggedIn();
        });
        $engine->registerFunction('color', function (float $note, bool $isComment = false): string {
            $type = '';
            if ($isComment) {
                if ($note < 0) $type = 'danger';
                if ($note === 0) $type = 'black';
                if ($note > 0) $type = 'success';
            } else {
                if ($note < 5) $type = 'danger';
                if ($note === 5) $type = 'warning';
                if ($note > 5) $type = 'success';
            }
            return $type;
        });
        $template = $engine->make($view);
        echo $template->render($data);
    }
}
