<?php
namespace App\Controllers;

use App\Helpers\Wrappers;
use App\Items\Review;

class HomeController {
    static public function get() {
        $review = new Review();
        $stats = $review->statsAll();
        Wrappers::plates('home', [
            'stats' => $stats
        ]);
    }
}
