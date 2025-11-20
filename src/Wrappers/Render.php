<?php

namespace App\Wrappers;

use App\Constants\App;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\MarkdownConverter;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use Psr\Http\Message\UriInterface;

class Render
{
    public static function plates(string $template, array $data = []): string
    {
        $engine = new Engine(__DIR__ . '/../../templates');
        $engine->loadExtension(new Asset(__DIR__ . '/../../public'));

        $engine->registerFunction('url', fn (string $path, ?array $query = null) => Env::app_url($path, $query));
        $engine->registerFunction('version', fn () => App::VERSION);
        $engine->registerFunction('loggedin', fn () => Session::isLoggedIn());
        $engine->registerFunction('theme', fn () => Cookies::theme());

        $engine->registerFunction('encrypt', fn (string $data) => Security::encrypt($data));
        $engine->registerFunction('hcaptcha_sitekey', fn () => Env::hcaptcha_sitekey());

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

    public static function markdown(string $text): string
    {
        $environment = new Environment([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 15,
            'max_delimiters_per_line' => 200,
        ]);
        $environment->addExtension(new InlinesOnlyExtension());

        $converter = new MarkdownConverter($environment);
        return $converter->convert($text);
    }
}
