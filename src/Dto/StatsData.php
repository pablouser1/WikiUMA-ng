<?php
namespace App\Dto;

/**
 * @template T
 */
readonly class StatsData
{
    public function __construct(
        public int $total,
        public float $avg,
        public ?int $min = null,
        public ?int $max = null,
        /** @var T */
        public mixed $for = null,
    ) {}
}
