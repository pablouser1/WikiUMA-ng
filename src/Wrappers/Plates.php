<?php

namespace App\Wrappers;

use App\Constants\App;
use App\Constants\Links;
use League\Plates\Engine;
use Psr\Http\Message\UriInterface;

class Plates
{
    public static function render(string $template, array $data = []): string
    {
        $engine = new Engine(__DIR__ . '/../../templates');

        $engine->registerFunction('url', fn (string $path, ?array $query = null) => Env::app_url($path, $query));
        $engine->registerFunction('links', fn () => Links::LIST);
        $engine->registerFunction('version', fn () => App::VERSION);
        $engine->registerFunction('loggedin', fn () => Session::isLoggedIn());

        $engine->registerFunction('pathWithQuery', fn (UriInterface $uri) => Misc::pathWithQuery($uri));
        $engine->registerFunction('uriQuery', fn (UriInterface $uri, array $origQuery, array $newData) => Misc::modifyQueryFromUri($uri, $origQuery, $newData));

        $engine->registerFunction('planAsignaturaSplit', fn (string $str) => Misc::planAsignaturaSplit($str));
        $engine->registerFunction('planAsignaturaJoin', fn (string $plan_id, string $asig_id) => Misc::planAsignaturaJoin($plan_id, $asig_id));

        $engine->registerFunction('contact', fn () => Env::app_contact());
        // -- STYLING -- //
        $engine->registerFunction('color', function (float $note, bool $isComment = false): string {
            $type = '';
            if ($isComment) {
                if ($note < 0) {
                    $type = 'danger';
                } elseif ($note === 0) {
                    $type = 'primary';
                } elseif ($note > 0) {
                    $type = 'success';
                }
            } else {
                if ($note < 5) {
                    $type = 'danger';
                } elseif ((5 <= $note) && ($note < 7)) {
                    $type = 'warning';
                } elseif ($note >= 7) {
                    $type = 'success';
                }
            }
            return $type;
        });

        return $engine->render($template, $data);
    }
}
