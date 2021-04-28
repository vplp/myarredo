<?php

use yii\console\controllers\MigrateController;

return [
    // params
    'params' => [
        'format' => [
            'date' => 'd.m.Y',
            'time' => 'i:H',
        ]
    ],
    // migration
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationPath' => __DIR__ . '/migrations',
        ],
    ],
];
