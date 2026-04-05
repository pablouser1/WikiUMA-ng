<?php

namespace App\Wrappers;

use Composer\InstalledVersions;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\MarkdownConverter;
use League\Plates\Engine;
use League\Plates\Extension\Asset;

class Render
{
    public static function plates(string $template, array $data = []): string
    {
        $engine = new Engine(__DIR__ . '/../../templates');
        $engine->loadExtension(new Asset(__DIR__ . '/../../public'));

        $engine->registerFunction('url', [Env::class, 'app_url']);
        $engine->registerFunction('version', fn() => InstalledVersions::getRootPackage()['pretty_version']);
        $engine->registerFunction('loggedin', [Session::class, 'isLoggedIn']);
        $engine->registerFunction('theme', [Cookies::class, 'theme']);

        $engine->registerFunction('encrypt', [Security::class, 'encrypt']);
        $engine->registerFunction('hcaptcha_sitekey', [Env::class, 'hcaptcha_sitekey']);

        $engine->registerFunction('pathWithQuery', [Misc::class, 'pathWithQuery']);
        $engine->registerFunction('uriQuery', [Misc::class, 'modifyQueryFromUri']);

        $engine->registerFunction('planAsignaturaSplit', [UMA::class, 'planAsignaturaSplit']);
        $engine->registerFunction('planAsignaturaJoin', [UMA::class, 'planAsignaturaJoin']);

        $engine->registerFunction('contact', [Env::class, 'app_contact']);
        // -- STYLING -- //
        $engine->registerFunction('color', function (float $note, bool $isComment = false): string {
            $type = '';
            if ($isComment) {
                if ($note < 0) {
                    $type = 'danger';
                } elseif ($note === 0.0) {
                    $type = 'primary';
                } elseif ($note > 0) {
                    $type = 'success';
                }
            } else {
                if ($note < 5) {
                    $type = 'danger';
                } elseif (5 <= $note && $note < 7) {
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
