<?php

namespace App\Dto;

use App\Enums\ReviewTypesEnum;

/**
 * @template T
 */
readonly class FromDto
{
    public function __construct(
        public string $target,
        public ReviewTypesEnum $type,
    ) {}
}
