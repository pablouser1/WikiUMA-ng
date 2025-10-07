<?php

namespace App\Wrappers;

class Crypto
{
    private const string ALGO = "aes-128-cbc";
    private const string SEPARATOR = "|";

    public static function encrypt(string $data): string
    {
        $ivlen = openssl_cipher_iv_length(self::ALGO);
        $iv = openssl_random_pseudo_bytes($ivlen);
        return self::__join(openssl_encrypt($data, self::ALGO, Env::app_key(), 0, $iv), $iv);
    }

    public static function decrypt(string $data): string
    {
        [$content, $iv] = self::__split($data);
        return openssl_decrypt($content, self::ALGO, Env::app_key(), 0, $iv);
    }

    public static function __join(string $encrypted, string $iv): string
    {
        $ivBase64 = base64_encode($iv);
        return base64_encode($encrypted . self::SEPARATOR . $ivBase64);
    }

    public static function __split(string $data): array
    {
        $dataTmp = base64_decode($data);
        $arr = explode(self::SEPARATOR, $dataTmp);
        $arr[1] = base64_decode($arr[1]);
        return $arr;
    }
}
