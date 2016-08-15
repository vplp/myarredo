<?php
return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'runtimePath' => '@runtime/console',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'modules' => require('modules.php'),
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => \thread\app\console\controllers\MigrateController::class,
            'migrationPaths' => [
                '@thread/modules/user/migrations',
                '@thread/modules/location/migrations',
                '@thread/modules/menu/migrations',
                '@thread/modules/page/migrations',
                '@thread/modules/news/migrations',
                '@thread/modules/seo/migrations',
                '@thread/modules/configs/migrations',
            ],
        ],
    ],
    'params' => [],
];
