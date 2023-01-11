<?php
namespace App\Helpers;

use Jojoee\Library\LeoProfanity;

class Profanity {
    static public function filter(string $message): string {
        $profanities = include __DIR__ . '/../../tools/profanities.php';
        $filter = new LeoProfanity();
        $filter->clearList();
        $filter->add($profanities);
        return $filter->clean($message);
    }
}
