<?php

namespace App\Enums;

/**
 * Enumerate all avilable cache engines.
 */
enum CacheEnum: string
{
    case JSON = "json";
    case APCU = "apcu";
    case REDIS = "redis";
}
