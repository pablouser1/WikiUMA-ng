<?php

namespace App\Constants;

abstract class Reactions
{
    public const array LIST = [
        400 => [
            [
                'name' => 'no.jpg',
                'alt' => 'Ryo says no',
            ],
        ],
        404 => [
            [
                'name' => '52.webp',
                'alt' => 'Bocchi confused',
            ],
        ],
        500 => [
            [
                'name' => 'ryover.jpg',
                'alt' => 'It\'s so ryover',
            ],
            [
                'name' => 'ezzerland-xwitha.gif',
                'alt' => 'Cat falling over',
            ],
        ],
        502 => [
            [
                'name' => 'imagina.webp',
                'alt' => 'Imagina que la UMA te tome en serio',
            ],
            [
                'name' => 'fixher.webp',
                'alt' => 'I can fix her con logo de la UMA',
            ],
            [
                'name' => 'learning.webp',
                'alt' => 'Are ya\' learning son con logo de la UMA',
            ],
        ],
    ];

    public static function random(int $code): ?object
    {
        if (!isset(self::LIST[$code])) {
            return null;
        }

        $items = self::LIST[$code];
        $item = $items[array_rand($items)];

        return (object) $item;
    }
}
