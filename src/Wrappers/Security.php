<?php

namespace App\Wrappers;

/**
 * Helper class used for security-based parts.
 */
class Security
{
    private const string ALGO = 'aes-128-ctr';

    public static function encrypt(string $data): string
    {
        $iv = openssl_random_pseudo_bytes(self::__ivLength());
        $cipher = openssl_encrypt($data, self::ALGO, Env::app_key(), OPENSSL_RAW_DATA, $iv);
        return Encoding::base64url_encode($iv . $cipher);
    }

    public static function decrypt(string $data): ?string
    {
        $dataTmp = Encoding::base64url_decode($data);
        if ($dataTmp === false) {
            return null;
        }

        $ivLength = self::__ivLength();
        $iv = substr($dataTmp, 0, $ivLength);
        $cipher = substr($dataTmp, $ivLength);

        $out = openssl_decrypt($cipher, self::ALGO, Env::app_key(), OPENSSL_RAW_DATA, $iv);
        return $out ?: null;
    }

    public static function captcha(string $response, string $client_ip): object
    {
        $data = [
            'secret' => Env::hcaptcha_secret(),
            'response' => $response,
            'remoteip' => $client_ip,
        ];

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, 'https://hcaptcha.com/siteverify');
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($verify);
        $resData = json_decode($res);

        return $resData;
    }

    public static function isXssNaive(string $input): bool
    {
        $pattern = '/<\s*script[^>]*>|javascript\s*:|on\w+\s*=/i';
        return preg_match($pattern, $input) === 1;
    }

    private static function __ivLength(): int
    {
        return openssl_cipher_iv_length(self::ALGO);
    }
}
