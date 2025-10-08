<?php

namespace App\Wrappers;

class Storage
{
    public static function path(string $filename): string
    {
        return __DIR__ . '/../../storage/' . basename($filename);
    }
}
