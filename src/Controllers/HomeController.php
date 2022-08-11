<?php
namespace App\Controllers;

use App\Helpers\Wrappers;

class HomeController {
    static public function get() {
        Wrappers::latte('home', [
            'title' => 'Inicio'
        ]);
    }
}
