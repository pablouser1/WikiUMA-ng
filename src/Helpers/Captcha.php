<?php
namespace App\Helpers;

use Gregwar\Captcha\CaptchaBuilder;

class Captcha {
    static public function build(): string {
        $builder = new CaptchaBuilder();
        $builder->build();
        $_SESSION['phrase'] = $builder->getPhrase();
        return $builder->inline();
    }

    static public function validate(string $captcha): bool {
        $builder = new CaptchaBuilder($_SESSION['phrase']);
        $valid = $builder->testPhrase($captcha);

        // Avoid using captcha more than once
        unset($_SESSION['phrase']);

        return $valid;
    }
}
