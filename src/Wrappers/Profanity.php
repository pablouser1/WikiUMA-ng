<?php

namespace App\Wrappers;

use App\Wrappers\CustomCheck;

class Profanity
{
    static public function filter(string $message): string
    {
        $filter = new CustomCheck();
        return $filter->cleanWords($message);
    }
}
