<?php
namespace App\Controllers;

use App\Helpers\Wrappers;

class LifehackController {
    public static function index() {
        Wrappers::plates('lifehacks/index');
    }

    public static function spam() {
        Wrappers::plates('lifehacks/spam');
    }
}
