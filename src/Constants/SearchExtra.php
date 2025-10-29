<?php

namespace App\Constants;

/**
 * Easter-eggs when searching
 */
class SearchExtra
{
    public const array ITEMS = [
        [
            'key' => 'apellido_1',
            'value' => '/enfiso/i',
            'url' => 'https://youtu.be/VHw7rEtawsM?t=51',
        ],
    ];

    public static function redirect(array $query): ?string
    {
        $url = null;
        $i = 0;
        while ($url === null && $i < count(self::ITEMS)) {
            $item = self::ITEMS[$i];
            $val = $query[$item['key']] ?? null;
            $match = preg_match($item['value'], $val);
            if ($match !== false && $match === 1) {
                $url = $item['url'];
            }

            $i++;
        }

        return $url;
    }
}
