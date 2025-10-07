<?php

namespace App\Wrappers;

class Cookies
{
    public static function theme(): string
    {
        return htmlspecialchars($_COOKIE['theme'] ?? 'dark');
    }
}
