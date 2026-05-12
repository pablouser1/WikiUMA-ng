<?php

namespace App\Dto;

/**
 * @template T
 */
readonly class StatsDto
{
    public function __construct(
        public int $total,
        public float $avg,
        /** @var T */
        public mixed $for = null,
    ) {}
}
