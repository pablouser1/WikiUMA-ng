<?php

namespace App\Wrappers;

/**
 * Helper class used for encrypting teacher's emails.
 * This is done so the email isn't shown to the client in plaintext.
 */
class Crypto
{
    private const string ALGO = "aes-128-cbc";
    private const string SEPARATOR = "|";

    public static function encrypt(string $data): string
    {
        $ivlen = openssl_cipher_iv_length(self::ALGO);
        $iv = openssl_random_pseudo_bytes($ivlen);
        return self::__join(openssl_encrypt($data, self::ALGO, Env::app_key_emails(), 0, $iv), $iv);
    }

    public static function decrypt(string $data): ?string
    {
        $tuple = self::__split($data);
        if ($tuple === null) {
            return null;
        }

        return openssl_decrypt($tuple[0], self::ALGO, Env::app_key_emails(), 0, $tuple[1]);
    }

    public static function __join(string $encrypted, string $iv): string
    {
        $ivBase64 = base64_encode($iv);
        return base64_encode($encrypted . self::SEPARATOR . $ivBase64);
    }

    public static function __split(string $data): ?array
    {
        $dataTmp = base64_decode($data);
        if ($dataTmp === false) {
            return null;
        }

        $arr = explode(self::SEPARATOR, $dataTmp);

        if (count($arr) !== 2) {
            return null;
        }

        $arr[1] = base64_decode($arr[1]);
        return $arr;
    }
}
