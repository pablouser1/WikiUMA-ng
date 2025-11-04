<?php

namespace App\Wrappers;

use Nette\Utils\FileSystem;

class Storage
{
    public static function get(string $filename): string|false
    {
        return file_get_contents(self::path($filename));
    }

    public static function save(string $filename, mixed $data): void
    {
        file_put_contents(self::path($filename), $data);
    }

    public static function exists(string $filename): bool
    {
        return file_exists(self::path($filename));
    }

    public static function path(string $filename): string
    {
        return __DIR__ . '/../../storage/' . basename($filename);
    }
}
