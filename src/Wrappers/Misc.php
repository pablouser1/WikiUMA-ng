<?php

namespace App\Wrappers;

class Misc
{
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
}
