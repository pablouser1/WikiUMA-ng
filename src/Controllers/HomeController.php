<?php
namespace App\Controllers;

use App\Helpers\Wrappers;

class HomeController {
    static public function get() {
        Wrappers::plates('home');
    }
}
