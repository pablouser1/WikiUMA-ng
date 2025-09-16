<?php

namespace App\Wrappers;

class Env
{
    public static function parse(string $path): void
    {
        $arr = @parse_ini_file($path, false, INI_SCANNER_TYPED);

        if ($arr === false) {
            return;
        }

        foreach ($arr as $key => $val) {
            putenv("$key=$val");
            $_ENV[$key] = $val;
        }
    }

    /**
     * Get full app url.
     */
    public static function app_url(string $path, ?array $query = null): string
    {
        $base = $_ENV['APP_URL'] ?? 'http://localhost:8000';
        $queryStr = '';

        if ($query !== null) {
            $queryStr = '?' . http_build_query($query);
        }

        return $base . $path . $queryStr;
    }

    public static function app_debug(): bool
    {
        return $_ENV['APP_DEBUG'] ?? false;
    }

    public static function app_key(): string
    {
        return $_ENV['APP_KEY'] ?? '';
    }

    public static function db(): array
    {
        $driver = $_ENV["DB_DRIVER"] ?? "mysql";
        $host = $_ENV["DB_HOST"] ?? "127.0.0.1";
        $port = $_ENV["DB_PORT"] ?? 3306;
        $user = $_ENV["DB_USER"] ?? "";
        $password = $_ENV["DB_PASSWORD"] ?? "";
        $name = $_ENV["DB_NAME"] ?? "wikiuma";

        return [
            "driver" => $driver,
            "host" => $host,
            "port" => $port,
            "database" => $name,
            "username" => $user,
            "password" => $password
        ];
    }
}
