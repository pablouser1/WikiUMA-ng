<?php

namespace App\Enums;

/**
 * Enumamerate all valid tag types.
 */
enum TagTypesEnum: int
{
    case POSITIVE = 0;
    case NEUTRAL = 1;
    case NEGATIVE = 2;
}
