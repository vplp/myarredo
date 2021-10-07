<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

return [
    'param' => [
        'class' => \thread\modules\sys\modules\configs\components\ConfigsParams::class,
    ],
    'growl' => [
        'class' => \thread\modules\sys\modules\growl\components\Growl::class,
    ],
    'logbook' => [
        'class' => \thread\modules\sys\modules\logbook\components\Logbook::class,
    ],
    'logbookByMonth' => [
        'class' => \thread\modules\sys\modules\logbook\components\LogbookByMonth::class,
    ],
    'logbookAuth' => [
        'class' => \thread\modules\sys\modules\logbook\components\LogbookAuth::class,
    ],
    'languages' => [
        'class' => \thread\app\model\Languages::class,
        'languageModel' => \thread\modules\sys\models\Language::class,
    ],
    //DEFAULT CACHE
    'cache' => [
        'class' => \yii\caching\FileCache::class,
        'cachePath' => '@runtime',
        'keyPrefix' => 'thread'
    ],
    'mailer' => [
        'class' => \yii\swiftmailer\Mailer::class,
        'useFileTransport' => false,
        'enableSwiftMailerLogging' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
        ],
    ],
    'request' => [
        'class' => \thread\app\web\Request::class,
    ],
    'urlManager' => [
        'class' => \thread\app\web\UrlManager::class,
        'enablePrettyUrl' => true,
        'enableStrictParsing' => true,
        'showScriptName' => false,
    ],
    'authManager' => [
        'class' => \yii\rbac\DbManager::class,
    ],
    'metatag' => [
        'class' => \thread\modules\seo\components\MetaTag::class
    ],
    'assetManager' => [
        'class' => \yii\web\AssetManager::class,
        'appendTimestamp' => true,
        'linkAssets' => false,
        'bundles' => [
            'yii\web\JqueryAsset' => [
                'js' => [
//                    YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    'jquery.min.js',
                ]
            ],
            'yii\bootstrap\BootstrapAsset' => [
                'css' => [
//                    YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    'css/bootstrap.min.css'
                ]
            ],
            'yii\bootstrap\BootstrapPluginAsset' => [
                'js' => [
//                    YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    'js/bootstrap.min.js'
                ]
            ],
            /* TODO : Решить вопрос с подключением минифицированного YII пакета*/
            'yii\web\YiiAsset' => [
                'js' => [
//                    YII_ENV_DEV ? 'yii.js' : 'yii.min.js',
                    'yii.js'
                ]
            ]
        ],
    ],
    'i18n' => [
        'class' => \thread\modules\sys\modules\translation\components\I18N::class,
        'languageModel' => \thread\modules\sys\models\Language::class,
        'enableCaching' => true,
        'cachingDuration' => 3600
    ],
    // Cache key for backend
    'cacheFrontend' => [
        'class' => 'yii\caching\FileCache',
        'cachePath' => Yii::getAlias('@runtime') . '/frontend/th'
    ],
];
