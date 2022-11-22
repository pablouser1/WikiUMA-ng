<?php
namespace App\Constants;

abstract class Links {
    const list = [
        [
            'name' => 'Centros',
            'endpoint' => '/centros',
            'color' => 'is-primary'
        ],
        [
            'name' => 'Acerca de',
            'endpoint' => '/about',
            'color' => 'is-info'
        ],
        [
            'name' => 'Términos de uso',
            'endpoint' => '/terms',
            'color' => 'is-warning'
        ]
    ];
}
