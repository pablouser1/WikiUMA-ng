<?php
namespace App\Helpers;

class Sorting {
    const SORT = ['created_at', 'votes'];
    const ORDER = ['asc', 'desc'];

    static public function isSortValid(string $sort): bool {
        return in_array($sort, self::SORT, true);
    }

    static public function isOrderValid(string $order): bool {
        return in_array($order, self::ORDER, true);
    }
}
