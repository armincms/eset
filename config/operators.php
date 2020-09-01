<?php return [ 
    'title' => 'ESET',
    'drivers' => [
        'eav' => [ 
            'title' => 'Eset Antivirus',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [EsetBuilder::class, 'eav'],
        ], 
        'ess' => [ 
            'title' => 'Eset Smart Security',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [EsetBuilder::class, 'ess'],
        ], 
        'essp' => [ 
            'title' => 'Eset Smart Security Premium',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [EsetBuilder::class, 'essp'],
        ], 
        'eis' => [ 
            'title' => 'Eset Internet Security',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [EsetBuilder::class, 'eis'],
        ],
        'eea' => [ 
            'title' => 'Eset Endpoint antivirus',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [EsetBuilder::class, 'eea'],
        ] ,
        'ees' => [ 
            'title' => 'Eset Endpoint Security',
            'fields'  => [
                'username', 'password', 'key'
            ],
            'builder' => [EsetBuilder::class, 'ees'],
        ] 
    ],
];