<?php

defined('DOMAIN_NAME') or define('DOMAIN_NAME', 'myarredo');
defined('DOMAIN_TYPE') or define('DOMAIN_TYPE', 'ru');

use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\{
    Category, Types, SubTypes
};
use console\models\{
    Product, Factory, Sale, ItalianProduct, ArticlesArticle, NewsArticle
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
            'redisCache' => [
                'class' => \yii\redis\Cache::class,
                'redis' => [
                    'hostname' => \getenv('REDIS_HOST'),
                    'port' => \getenv('REDIS_PORT'),
                    'database' => 0,
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
                    '@thread/modules/sys/modules',
                    '@thread/modules/seo/modules',
                    '@common/modules/seo/modules',
                    '@common/modules/sys/modules',
                    '@common/modules/shop/modules',
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
            'catalog-translate' => [
                'class' => \console\controllers\CatalogTranslateController::class,
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
            'elastic-search' => [
                'class' => \console\controllers\ElasticSearchController::class,
            ],
            'send-pulse' => [
                'class' => \console\controllers\SendPulseController::class,
            ],
            'redirects' => [
                'class' => \console\controllers\RedirectsController::class,
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
                        ],
                        [
                            'class' => ArticlesArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/articles/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ],
                        [
                            'class' => NewsArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/news/article/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ]
                    ],
                    'uk' => [
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
                        ],
                        [
                            'class' => ArticlesArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/articles/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ],
                        [
                            'class' => NewsArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/news/article/' . $model['alias'] . '/',
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
                                    'loc' => '/catalog/' . $model['alias_en'] . '/',
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
                                    'loc' => '/catalog/c--' . $model['alias_en'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                                    'loc' => '/product/' . $model['alias_en'] . '/',
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
                        ],
                        [
                            'class' => ArticlesArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/articles/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ],
                        [
                            'class' => NewsArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/news/article/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ]
                    ],
                    'it' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/' . $model['alias_it'] . '/',
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
                                    'loc' => '/catalog/c--' . $model['alias_it'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                                    'loc' => '/product/' . $model['alias_it'] . '/',
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
                        ],
                        [
                            'class' => ArticlesArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/articles/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ],
                        [
                            'class' => NewsArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/news/article/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ]
                    ],
                    'de' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/' . $model['alias_de'] . '/',
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
                                    'loc' => '/catalog/c--' . $model['alias_de'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                                    'loc' => '/product/' . $model['alias_de'] . '/',
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
                        ],
                        [
                            'class' => ArticlesArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/articles/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ],
                        [
                            'class' => NewsArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/news/article/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ]
                    ],
                    'fr' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/' . $model['alias_fr'] . '/',
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
                                    'loc' => '/catalog/c--' . $model['alias_fr'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                                    'loc' => '/product/' . $model['alias_fr'] . '/',
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
                        ],
                        [
                            'class' => ArticlesArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/articles/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ],
                        [
                            'class' => NewsArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/news/article/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ]
                    ],
                    'he' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/' . $model['alias_he'] . '/',
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
                                    'loc' => '/catalog/c--' . $model['alias_he'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/catalog/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                                    'loc' => '/product/' . $model['alias_he'] . '/',
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
                        ],
                        [
                            'class' => ArticlesArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/articles/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
                        ],
                        [
                            'class' => NewsArticle::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/news/article/' . $model['alias'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.5
                                ];
                            },
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
                    [
                        'loc' => '/page/sitemap/',
                        'lastmod' => date('c', time()),
                        'changefreq' => 'daily',
                        'priority' => 0.5
                    ],
                ]
            ],
            'sitemap-sale' => [
                'class' => \console\controllers\SitemapSaleController::class,
                'models' => [
                    'ru' => [
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
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'uk' => [
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
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'en' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/' . $model['alias_en'] . '/',
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
                                    'loc' => '/sale/c--' . $model['alias_en'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'it' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/' . $model['alias_it'] . '/',
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
                                    'loc' => '/sale/c--' . $model['alias_it'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'de' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/' . $model['alias_de'] . '/',
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
                                    'loc' => '/sale/c--' . $model['alias_de'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'fr' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/' . $model['alias_fr'] . '/',
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
                                    'loc' => '/sale/c--' . $model['alias_fr'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
            ],
            'sitemap-italian-product' => [
                'class' => \console\controllers\SitemapItalianProductController::class,
                'models' => [
                    'ru' => [
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
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'uk' => [
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
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'en' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/' . $model['alias_en'] . '/',
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
                                    'loc' => '/sale-italy/c--' . $model['alias_en'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'it' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/' . $model['alias_it'] . '/',
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
                                    'loc' => '/sale-italy/c--' . $model['alias_it'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'de' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/' . $model['alias_de'] . '/',
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
                                    'loc' => '/sale-italy/c--' . $model['alias_de'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'fr' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/' . $model['alias_fr'] . '/',
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
                                    'loc' => '/sale-italy/c--' . $model['alias_fr'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
                    'he' => [
                        [
                            'class' => Category::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/' . $model['alias_he'] . '/',
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
                                    'loc' => '/sale-italy/c--' . $model['alias_he'] . '/',
                                    'lastmod' => date('c', $model['updated_at']),
                                    'changefreq' => 'daily',
                                    'priority' => 0.8
                                ];
                            }
                        ],
                        [
                            'class' => SubTypes::class,
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => '/sale-italy/c--t--s--f--c--country--colors--' . $model['alias'] . '/',
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
            'seo-directlink' => [
                'class' => \console\controllers\SeoDirectlinkController::class,
            ],
            'articles' => [
                'class' => \console\controllers\ArticlesController::class,
            ],
            'news' => [
                'class' => \console\controllers\NewsController::class,
            ],
        ],
        'params' => [],
    ]
);
