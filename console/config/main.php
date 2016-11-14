<?php
use yii\helpers\ArrayHelper;

$main = require(dirname(__DIR__, 2) . '/common/config/main.php');
unset($main['bootstrap']['languages'], $main['components']['request']);

return ArrayHelper::merge(
    $main,
    [
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
            'request' => [
                'class' => \yii\console\Request::class,
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
                    '@thread/modules/sys/migrations',
                    '@thread/modules/sys/modules/configs/migrations',
                    '@thread/modules/polls/migrations',
                    '@thread/modules/sys/modules/growl/migrations',
                    '@thread/modules/sys/modules/crontab/migrations',
                    '@thread/modules/correspondence/migrations',
                    '@thread/modules/shop/migrations',
                ],
            ],
        ],
        'params' => [],
    ]
);
