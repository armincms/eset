<?php 
use Armincms\Eset\Builder;

return [ 
    'title' => 'ESET',
    'drivers' => [
        'eav' => [ 
            'title' => 'Eset Antivirus',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'eav'],
        ], 
        'ess' => [ 
            'title' => 'Eset Smart Security',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'ess'],
        ], 
        'essp' => [ 
            'title' => 'Eset Smart Security Premium',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'essp'],
        ], 
        'eis' => [ 
            'title' => 'Eset Internet Security',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'eis'],
        ],
        'eea' => [ 
            'title' => 'Eset Endpoint antivirus',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'eea'],
        ] ,
        'ees' => [ 
            'title' => 'Eset Endpoint Security',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'ees'],
        ], 
        'eeas' => [ 
            'title' => 'Eset Endpoint antivirus (Server)',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'eea'],
            'parent' => 'eea',
        ] ,
        'eess' => [ 
            'title' => 'Eset Endpoint Security (Server)',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'ees'],
            'parent' => 'ees',
        ],
        'eint' => [ 
            'title' => 'Eset Network Client',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [Builder::class, 'eint'],
        ] 
    ],
];
