<?php

namespace App\Constants;

/**
 * Links used both in navbar and home.
 */
abstract class Links
{
    public const array LIST = [
        [
            'name' => 'Directorio',
            'path' => '/centros',
            'color' => 'is-primary',
            'icon' => 'building',
        ],
        [
            'name' => 'Informes',
            'path' => '/reports',
            'color' => 'is-link',
            'icon' => 'stats-report',
        ],
        [
            'name' => 'Acerca de / FAQ',
            'path' => '/about',
            'color' => 'is-info',
            'icon' => 'info-circle',
        ],
        [
            'name' => 'Legal',
            'path' => '/legal',
            'color' => 'is-warning',
            'icon' => 'warning-triangle',
        ],
    ];
}
