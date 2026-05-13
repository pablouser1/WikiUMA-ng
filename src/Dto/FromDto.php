<?php

namespace App\Dto;

use App\Enums\ReviewTypeEnum;

readonly class FromDto
{
    public function __construct(
        public string $target,
        public ReviewTypeEnum $type,
    ) {}
}
