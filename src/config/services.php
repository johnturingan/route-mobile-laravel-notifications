<?php

return [
    'route-mobile-notifications' => [
        'name' => 'RMLViber',
        'host' => 'https://apis.rmlconnect.net',
        'gateway' => \Snp\Notifications\Rml\Services\RouteMobileGateway::class,
        'username' => 'username',
        'password' => 'password',
        'cache' => false
    ]
];