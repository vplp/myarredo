<?php

use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\{
    Category, Types
};
use console\models\{
    Product, Factory, Sale, ItalianProduct
};
use frontend\modules\seo\modules\directlink\models\Directlink;

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
            'catalog-product' => [
                'class' => \console\controllers\CatalogProductController::class,
            ],
            'catalog-sale' => [
                'class' => \console\controllers\CatalogSaleController::class,
            ],
            'catalog-factory' => [
                'class' => \console\controllers\CatalogFactoryController::class,
            ],
            'catalog-italian-product' => [
                'class' => \console\controllers\CatalogItalianProductController::class,
            ],
            'exchange-rates' => [
                'class' => \console\controllers\ExchangeRatesController::class,
            ],
            'stats' => [
                'class' => \console\controllers\StatsController::class,
            ],
            'elasticsearch' => [
                'class' => \console\controllers\ElasticSearchController::class,
            ],
            'send-pulse' => [
                'class' => \console\controllers\SendPulseController::class,
            ],
            'sitemap' => [
                'class' => \console\controllers\SitemapController::class,
                'models' => [
                    'ru' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            },
                        ],
                        [
                            'class' => Types::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/c--' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            },
                        ],
                        [
                            'class' => Directlink::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => $model['url'],
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            },
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
                            },
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
                            },
                        ]
                    ],
                    'en' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/' . $model['alias2'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => Types::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/c--' . $model['alias2'] . '/',
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
            'sitemap-sale' => [
                'class' => \console\controllers\SitemapSaleController::class,
                'models' => [
                    [
                        'class' => Category::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/sale/' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        },
                        'dataClosureCom' => function ($model) {
                            return [
                                'loc' => '/sale/' . $model['alias2'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        }
                    ],
                    [
                        'class' => Types::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/sale/c--' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        },
                        'dataClosureCom' => function ($model) {
                            return [
                                'loc' => '/sale/c--' . $model['alias2'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        }
                    ],
                    [
                        'class' => Sale::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/sale-product/' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.5
                            ];
                        }
                    ],
                ],
            ],
            'sitemap-italian-product' => [
                'class' => \console\controllers\SitemapItalianProductController::class,
                'models' => [
                    [
                        'class' => Category::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/sale-italy/' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        },
                        'dataClosureCom' => function ($model) {
                            return [
                                'loc' => '/sale-italy/' . $model['alias2'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        }
                    ],
                    [
                        'class' => Types::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/sale-italy/c--' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        },
                        'dataClosureCom' => function ($model) {
                            return [
                                'loc' => '/sale-italy/c--' . $model['alias2'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.8
                            ];
                        }
                    ],
                    [
                        'class' => ItalianProduct::class,
                        'dataClosure' => function ($model) {
                            return [
                                'loc' => '/sale-italy-product/' . $model['alias'] . '/',
                                'lastmod' => date('c', $model['updated_at']),
                                'changefreq' => 'daily',
                                'priority' => 0.5
                            ];
                        }
                    ],
                ],
            ],
            'sitemap-image' => [
                'class' => \console\controllers\SitemapImageController::class,
                'models' => [
                    [
                        'class' => Product::class,
                        'dataClosure' => function ($model) {
                            $module = Yii::$app->getModule('catalog');
                            $url = $module->getProductUploadUrl();

                            if ($model['image_link']) {
                                return [
                                    'loc' => '/product/' . $model['alias'] . '/',
                                    'image_link' => $url . '/' . $model['image_link'],
                                    'title' => $model['lang']['title'],
                                ];
                            }
                        }
                    ],
                ],
                'urls' => []
            ],
        ],
        'params' => [],
    ]
);
