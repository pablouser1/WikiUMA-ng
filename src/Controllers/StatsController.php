<?php
namespace App\Controllers;

use App\DB;
use App\Helpers\Wrappers;

class StatsController {
    static public function get() {
        $db = new DB;
        $stats = $db->getStatsTotal();

        Wrappers::latte('stats', [
            'title' => 'Estadísticas',
            'stats' => $stats
        ]);
    }
}
