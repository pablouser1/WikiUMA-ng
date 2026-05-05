<?php

namespace App\Constants;

use Composer\InstalledVersions;

/**
 * App-specific constants.
 */
abstract class App
{
    public const int PAGINATION_MAX_ITEMS = 15;

    public static function version(): string
    {
        return InstalledVersions::getRootPackage()['pretty_version'];
    }
}
