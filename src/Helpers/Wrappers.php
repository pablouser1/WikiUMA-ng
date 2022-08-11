<?php
namespace App\Helpers;

class Wrappers {
    static public function latte(string $template, array $params = []) {
        $latte = new \Latte\Engine;
        $cache_path = Misc::env('LATTE_CACHE', __DIR__ . '/../../cache/latte');
        $latte->setTempDirectory($cache_path);
        $latte->addFunction('path', function (string $endpoint = ''): string {
            return Misc::url($endpoint);
        });
        $latte->addFunction('version', function (): string {
            return \Composer\InstalledVersions::getVersion('pablouser1/wikiuma-ng');
        });
        $latte->addFunction('color', function (float $note, bool $isComment = false): string {
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

        $latte->render(Misc::getView($template), $params);
    }
}
