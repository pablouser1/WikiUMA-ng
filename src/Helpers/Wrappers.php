<?php
namespace App\Helpers;

class Wrappers {
    static public function latte() {
        $latte = new \Latte\Engine;
        $cache_path = Misc::env('LATTE_CACHE', __DIR__ . '/../../cache/latte');
        $latte->setTempDirectory($cache_path);
        $latte->addFunction('path', function (string $endpoint = ''): string {
            return Misc::url($endpoint);
        });
        $latte->addFunction('version', function (): string {
            return \Composer\InstalledVersions::getVersion('pablouser1/wikiuma-ng');
        });
        $latte->addFunction('color', function (float $note): string {
            if ($note < 5) return 'danger';
            if ($note === 5) return 'warning';
            if ($note > 5) return 'success';
        });
        return $latte;
    }
}
