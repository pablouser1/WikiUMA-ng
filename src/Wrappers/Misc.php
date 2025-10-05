<?php

namespace App\Wrappers;

use Psr\Http\Message\UriInterface;

class Misc
{
    public static function modifyQueryFromUri(UriInterface $uri, array $origQuery, array $newData): UriInterface
    {
        $newQuery = [
            ...$origQuery,
            ...$newData,
        ];

        return $uri->withQuery(http_build_query($newQuery));
    }

    public static function parseHTML(?string $html): ?\DOMDocument
    {
        if ($html) {
            $doc = new \DOMDocument();
            $success = @$doc->loadHTML($html);
            if ($success) {
                return $doc;
            }
        }
        return null;
    }

    public static function currentPath(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function planAsignaturaSplit(string $str): ?array
    {
        $arr = explode(';', $str);
        if (count($arr) === 2) {
            return $arr;
        }

        return null;
    }

    public static function planAsignaturaJoin(string $plan_id, string $asig_id): string
    {
        return $plan_id . ';' . $asig_id;
    }
}
