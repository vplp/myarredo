<?php

use yii\console\controllers\MigrateController;

/**
 * Translation config file.
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package thread\modules\sys\modules\translation
 */
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
