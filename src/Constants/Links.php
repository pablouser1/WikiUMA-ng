<?php
namespace App\Constants;

abstract class Links {
    const list = [
        [
            'name' => 'Centros',
            'endpoint' => '/centros',
            'color' => 'is-primary',
            'icon' => 'list'
        ],
        [
            'name' => 'Acerca de',
            'endpoint' => '/about',
            'color' => 'is-info',
            'icon' => 'info'
        ],
        [
            'name' => 'Legal',
            'endpoint' => '/legal',
            'color' => 'is-warning',
            'icon' => 'danger'
        ]
    ];
}
