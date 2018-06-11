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
            'urlManager' => [
                'suffix' => '/',
                'hostInfo' => '',
                'baseUrl' => '',
                'rules' => [
                    'catalog/<filter:[\;\-\w\d]+>' => 'catalog/category/list',
                    'product/<alias:[\w\-]+>' => 'catalog/product/view',
                ]
            ],
            'elasticsearch' => [
                'class' => \yii\elasticsearch\Connection::class,
                'autodetectCluster' => false,
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
                    '@common/modules/sys/modules',
                    '@thread/modules/sys/modules',
                    '@common/modules/seo/modules',
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
            'cron' => [
                'class' => \console\controllers\CronController::class,
            ],
            'stats' => [
                'class' => \console\controllers\StatsController::class,
            ],
            'elastic-search' => [
                'class' => \console\controllers\ElasticSearchController::class,
            ],
            'send-pulse' => [
                'class' => \console\controllers\SendPulseController::class,
            ],
            'sitemap' => [
                'class' => \console\controllers\SitemapController::class,
                'models' => [
                    [
                        'class' => \frontend\modules\catalog\models\Category::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/catalog/'. $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        }
                    ],
                    [
                        'class' => \frontend\modules\catalog\models\Product::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/product/'. $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.5
                            ];
                        }
                    ],
                    [
                        'class' => \frontend\modules\catalog\models\Factory::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/factory/'. $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.5
                            ];
                        }
                    ]
                ]
            ],
        ],
        'params' => [],
    ]
);
