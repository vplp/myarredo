<?php
use yii\helpers\ArrayHelper;

$main = require(dirname(__DIR__, 2) . '/common/config/main.php');
foreach ($main['bootstrap'] as $itemkey => $item) {
    if ($item == 'languages') {
        unset($main['bootstrap'][$itemkey]);
        break;
    }
}
unset($itemkey, $item, $main['components']['request']);

$rootDir = dirname(__DIR__, 2);

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
                'templateFile' => '@console/migrationsTemplate/migration.php',
                'migrationPathsOfModules' => [
                    '@console',
                    '@thread/modules',
                    '@common/modules',
                    '@backend/modules',
                    '@frontend/modules',
                    '@thread/modules/sys/modules',
                    '@thread/modules/seo/modules',
                ],
                'migrationPaths' => [
                ],
            ],
            'clean' => [
                'class' => 'console\controllers\CleanController',
                'assetPaths' => [
                    "$rootDir/web/assets",
                ],
                'runtimePaths' => [
                    "$rootDir/runtime",
                    "$rootDir/temp",
                ],
            ],
        ],
        'params' => [],
    ]
);
