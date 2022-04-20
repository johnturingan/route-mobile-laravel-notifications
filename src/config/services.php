<?php

return [
    'route-mobile-notifications' => [
        'host' => 'https://apis.rmlconnect.net',
        'gateway' => \Snp\Notifications\Rml\Services\RouteMobileGateway::class,
        'username' => 'username',
        'password' => 'password',
    ]
];