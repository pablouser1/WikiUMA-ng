<?php

namespace App\Wrappers;

use App\Enums\CacheEnum;

/**
 * Wrapper for Environment Variables.
 */
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

    /**
     * Get app's debugging state.
     */
    public static function app_debug(): bool
    {
        return $_ENV['APP_DEBUG'] ?? false;
    }

    /**
     * Get app's encryption key.
     */
    public static function app_key(): string
    {
        return $_ENV['APP_KEY'] ?? '';
    }

    /**
     * Get cache engine to be used.
     */
    public static function api_cache(): ?CacheEnum
    {
        $value = $_ENV['API_CACHE'] ?? null;
        return $value !== null ? CacheEnum::tryFrom($value) : null;
    }

    /**
     * Get db credentials.
     */
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

    /**
     * Get redis credentials.
     */
    public static function redis(): array
    {
        $host = $_ENV['REDIS_HOST'] ?? null;
        $port = $_ENV['REDIS_PORT'] ?? null;
        $password = $_ENV['REDIS_PASSWORD'] ?? null;

        return [
            'host' => $host,
            'port' => $port,
            'password' => $password,
        ];
    }
}
