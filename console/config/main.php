<?php

use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\Category;

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
                'rules' => require(dirname(__DIR__, 2) . '/frontend/config/part/url-rules.php'),
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
            'cron' => [
                'class' => \console\controllers\CronController::class,
            ],
            'sitemap' => [
                'class' => \console\controllers\SitemapController::class,
                'models' => [
                    [
                        'class' => \frontend\modules\catalog\models\Category::class,
//                        'scope' => function ($model) {
//                            /** @var \yii\db\ActiveQuery $model */
//                            $model->select(['url', 'lastmod']);
//                            $model->andWhere(['is_deleted' => 0]);
//                        },
                        'dataClosure' => function ($model) {
                            /** @var self $model */
                            return [
                                'loc' => Category::getUrl($model->alias),
                                'lastmod' => date('c', $model->updated_at),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        }
                    ]
                ]
            ],
        ],
        'params' => [],
    ]
);
