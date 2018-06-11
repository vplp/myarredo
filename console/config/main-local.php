<?php

return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => \yii\gii\Module::class,
    ],
    'components' => [
        'elasticsearch' => [
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'], // '192.168.0.1:9200'
            ],
        ],
    ],
];
