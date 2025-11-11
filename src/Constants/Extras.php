<?php

namespace App\Constants;

use App\Wrappers\Misc;

/**
 * Easter-eggs when searching
 */
class Extras
{
    private const array SEARCH_ITEMS = [
        [
            'key' => 'apellido_1',
            'value' => '/enfiso/i',
            'url' => 'https://youtu.be/VHw7rEtawsM?t=51',
        ],
    ];

    private const string MY_FIRST_XSS_REDIRECT = 'https://youtu.be/g7_I6kj9fTc';

    public static function search(array $query): ?string
    {
        $url = null;
        $i = 0;
        while ($url === null && $i < count(self::SEARCH_ITEMS)) {
            $item = self::SEARCH_ITEMS[$i];
            $val = $query[$item['key']] ?? null;
            $match = preg_match($item['value'], $val);
            if ($match !== false && $match === 1) {
                $url = $item['url'];
            }

            $i++;
        }

        return $url;
    }

    public static function review(string $rawBody): ?string
    {
        return Misc::isXss($rawBody) ? self::MY_FIRST_XSS_REDIRECT : null;
    }
}
