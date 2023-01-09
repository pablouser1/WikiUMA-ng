<?php
namespace App\Helpers;

class Mode {
    static public function get(): int {
        return Misc::env('APP_MODE', 0);
    }

    static public function handle(int $maxMode = 0): bool {
        $envMode = Misc::env('APP_MODE', 0);

        // 0: None
        // 1: Write-protection
        // 2: Read-protection

        if ($maxMode > $envMode) {
            return true;
        }

        return Misc::isLoggedIn();
    }
}
