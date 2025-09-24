<?php

namespace App\Constants;

/**
 * Reaction images used on error page.
 */
abstract class Reactions
{
    /** @var array<int,array{"name": string, "alt": string}>  */
    public const array LIST = [
        400 => [
            [
                'name' => 'no.jpg',
                'alt' => 'Ryo says no',
            ],
        ],
        403 => [
            [
                'name' => 'naonao.jpg',
                'alt' => 'Não, não amigão',
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

    /**
     * Picks random reaction from specific status code.
     *
     * @param int $code HTTP Code
     * @return ?object{"name": string, "alt": string}
     */
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
