<?php
namespace App\Controllers;

use Gregwar\Captcha\CaptchaBuilder;

class CaptchaController {
    static public function get() {
        header('Content-type: image/jpeg');
        $builder = new CaptchaBuilder;
        $builder->build();
        $_SESSION['phrase'] = $builder->getPhrase();
        $builder->output();
    }
}
