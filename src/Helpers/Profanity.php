<?php
namespace App\Helpers;

use App\CustomCheck;

class Profanity {
    static public function filter(string $message): string {
        $filter = new CustomCheck(__DIR__ . '/../../tools/profanities.php');
        return $filter->cleanWords($message);
    }
}
