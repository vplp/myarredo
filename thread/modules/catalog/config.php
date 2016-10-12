<?php

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
return [
    'params' => [],
    //Migration
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => __DIR__ . '/migrations',
        ],
    ],
];