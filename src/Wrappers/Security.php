<?php

namespace App\Wrappers;

/**
 * Helper class used for security-based parts.
 */
class Security
{
    private const string ALGO = "aes-128-cbc";
    private const string SEPARATOR = "|";

    public static function encrypt(string $data): string
    {
        $ivlen = openssl_cipher_iv_length(self::ALGO);
        $iv = openssl_random_pseudo_bytes($ivlen);
        return self::__join(openssl_encrypt($data, self::ALGO, Env::app_key(), 0, $iv), $iv);
    }

    public static function decrypt(string $data): ?string
    {
        $tuple = self::__split($data);
        if ($tuple === null) {
            return null;
        }

        return openssl_decrypt($tuple[0], self::ALGO, Env::app_key(), 0, $tuple[1]);
    }

    public static function captcha(string $response): object
    {
        $data = [
            'secret' => Env::hcaptcha_secret(),
            'response' => $response,
        ];

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($verify);
        $resData = json_decode($res);

        return $resData;
    }

    private static function __join(string $encrypted, string $iv): string
    {
        $ivBase64 = base64_encode($iv);
        return base64_encode($encrypted . self::SEPARATOR . $ivBase64);
    }

    private static function __split(string $data): ?array
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
