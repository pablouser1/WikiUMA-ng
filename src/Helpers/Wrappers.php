<?php
namespace App\Helpers;

use App\Constants\Links;

class Wrappers {
    static public function db(): \PDO {
        $driver = Misc::env('DB_DRIVER', 'mysql');
        $host = Misc::env('DB_HOST', 'localhost');
        $port = Misc::env('DB_PORT', 3306);
        $db = Misc::env('DB_NAME', 'wikiuma');
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

        // -- Basic -- //
        $engine->registerFunction('url', function(string $endpoint, array $query = []): string {
            return Misc::url($endpoint, $query);
        });
        $engine->registerFunction('current_url', function(bool $withQuery = false): string {
            $url = Misc::url(router()->getCurrentUri());
            if ($withQuery && !empty($_GET)) $url .= '?' . http_build_query($_GET);
            return $url;
        });
        $engine->registerFunction('version', function (): string {
            return \Composer\InstalledVersions::getVersion('pablouser1/wikiuma-ng');
        });
        $engine->registerFunction('mode', function (): int {
            return Mode::get();
        });

        // -- Control -- //
        $engine->registerFunction('isLoggedIn', function (bool $isAdmin = false): bool {
            return Misc::isLoggedIn($isAdmin);
        });
        $engine->registerFunction('links', function (): array {
            return Links::list;
        });
        $engine->registerFunction('captcha', function (): string {
            return Captcha::build();
        });
        $engine->registerFunction('page', function (): int {
            return Misc::getPage();
        });
        $engine->registerFunction('url_to', function (string $data, int $subject_id): string {
            $isSubject = boolval($subject_id);
            if ($isSubject) {
                $subject = Subject::split($data);
                return Misc::url('/asignaturas/' . $subject->asig . '/' . $subject->plan);
            }

            return Misc::url('/profesores', ['idnc' => $data]);
        });
        $engine->registerFunction('mode_handle', function (int $maxMode = 0): int {
            return Mode::handle($maxMode);
        });

        // -- Styling -- //
        $engine->registerFunction('color', function (float $note, bool $isComment = false): string {
            $type = '';
            if ($isComment) {
                if ($note < 0) $type = 'danger';
                elseif ($note === 0) $type = 'primary';
                elseif ($note > 0) $type = 'success';
            } else {
                if ($note < 5) $type = 'danger';
                elseif ((5 <= $note) && ($note < 7)) $type = 'warning';
                elseif ($note >= 7) $type = 'success';
            }
            return $type;
        });
        $engine->registerFunction('tag', function (int $type): string {
            $color = '';
            switch ($type) {
                case -1:
                    $color = 'danger';
                    break;
                case 0:
                    $color = 'primary';
                    break;
                case 1:
                    $color = 'success';
                    break;
            }
            return $color;
        });
        $engine->registerFunction('selected', function (string $needle, string $key, array $arr = []): string {
            if (empty($arr)) {
                $arr = $_GET;
            }
            return isset($arr[$key]) && $arr[$key] === $needle ? 'selected' : '';
        });
        $engine->registerFunction('selected_tag', function (int $type, int $val): string {
            return $type === $val ? 'selected' : '';
        });

        // Run
        $template = $engine->make($view);
        echo $template->render($data);
    }
}
