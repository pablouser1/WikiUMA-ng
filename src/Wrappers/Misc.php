<?php

namespace App\Wrappers;

use Psr\Http\Message\UriInterface;

class Misc
{
    public static function pathWithQuery(UriInterface $uri): string
    {
        $str = $uri->getPath();
        if ($uri->getQuery() !== '') {
            $str .= '?' . $uri->getQuery();
        }

        return $str;
    }

    public static function modifyQueryFromUri(UriInterface $uri, array $origQuery, array $newData): UriInterface
    {
        $newQuery = [
            ...$origQuery,
            ...$newData,
        ];

        $filteredQuery = [];

        foreach ($newQuery as $key => $value) {
            $filteredQuery[$key] = strval($value);
        }

        return $uri->withQuery(http_build_query($filteredQuery));
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

    public static function DOMInnerHTML(\DOMNode $element): string
    {
        $innerHTML = '';
        $children = $element->childNodes;

        foreach ($children as $child) {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
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
