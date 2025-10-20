<?php

namespace App\Constants;

/**
 * Links used on Navbar.
 */
abstract class Links
{
    public const array LIST = [
        [
            'name' => 'Directorio',
            'path' => '/centros',
        ],
        [
            'name' => 'Informes',
            'path' => '/reports',
        ],
        [
            'name' => 'Acerca de / FAQ',
            'path' => '/about',
        ],
        [
            'name' => 'Contacto',
            'path' => '/contact',
        ],
        [
            'name' => 'Legal',
            'path' => '/legal',
        ],
    ];
}
