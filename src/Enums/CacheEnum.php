<?php

namespace App\Enums;

enum CacheEnum: string
{
    case JSON = "json";
    case APCU = "apcu";
    case REDIS = "redis";
}
