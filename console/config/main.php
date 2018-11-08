<?php

use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\{
    Category, Product, Factory
};

$main = require(dirname(__DIR__, 2) . '/common/config/main.php');

foreach ($main['bootstrap'] as $itemKey => $item) {
    if ($item == 'languages') {
        unset($main['bootstrap'][$itemKey]);
        break;
    }
}
unset($itemKey, $item, $main['components']['request']);

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
                        'class' => Category::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/catalog/' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        }
                    ],
                    [
                        'class' => Product::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/product/' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.5
                            ];
                        }
                    ],
                    [
                        'class' => Factory::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/factory/' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.5
                            ];
                        }
                    ]
                ],
                'urls' => [
                    [
                        'loc' => '/contacts/',
                        'lastmod' => date('c', time()),
                        'changefreq' => 'daily',
                        'priority' => 0.5
                    ],
                    [
                        'loc' => '/sale/',
                        'lastmod' => date('c', time()),
                        'changefreq' => 'daily',
                        'priority' => 0.5
                    ],
                    [
                        'loc' => '/factories/',
                        'lastmod' => date('c', time()),
                        'changefreq' => 'daily',
                        'priority' => 0.5
                    ],
                ]
            ],
            'sitemap-image' => [
                'class' => \console\controllers\SitemapImageController::class,
                'models' => [
                    [
                        'class' => Product::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/product/' . $model['alias'] . '/',
                                'image_link' => Product::getImage($model['image_link']),
                            ];
                        }
                    ],
                    [
                        'class' => Factory::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/factory/' . $model['alias'] . '/',
                                'image_link' => Factory::getImage($model['image_link'])
                            ];
                        }
                    ]
                ],
                'urls' => []
            ],
        ],
        'params' => [],
    ]
);
