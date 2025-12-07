<?php

namespace App\Wrappers;

class Encoding
{
    /**
     * Encode data to Base64URL
     */
    public static function base64url_encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Decode data from Base64URL
     */
    public static function base64url_decode(string $data, bool $strict = false): string|false
    {
        return base64_decode(strtr($data, '-_', '+/'), $strict);
    }
}
