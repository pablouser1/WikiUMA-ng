<?php
namespace App\Constants;

abstract class Links {
    const list = [
        [
            'name' => 'Centros',
            'endpoint' => '/centros',
            'color' => 'is-primary',
            'icon' => 'organisation'
        ],
        [
            'name' => 'Acerca de',
            'endpoint' => '/about',
            'color' => 'is-info',
            'icon' => 'info'
        ],
        [
            'name' => 'Lifehacks',
            'endpoint' => '/lifehacks',
            'color' => 'is-success',
            'icon' => 'bulb'
        ],
        [
            'name' => 'Legal',
            'endpoint' => '/legal',
            'color' => 'is-warning',
            'icon' => 'danger'
        ]
    ];
}
