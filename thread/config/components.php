<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    'configs' => [
        'class' => \thread\modules\configs\components\ConfigsParams::class,
    ],
    'languages' => [
        'class' => \thread\app\model\Languages::class,
        'languageModel' => \thread\app\model\Language::class,
    ],
    //DEFAULT CACHE
    'cache' => [
        'class' => yii\caching\FileCache::class,
        'cachePath' => '@runtime',
        'keyPrefix' => 'thread'
    ],
    'mailer' => [
        'class' => yii\swiftmailer\Mailer::class,
//        'viewPath' => '@common/mail',
        'useFileTransport' => true,
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
        'translations' => [
            'app' => [
                'class' => \yii\i18n\PhpMessageSource::class,
                'basePath' => '@thread/app/messages',
                'fileMap' => [
                    'app' => 'app.php',
                ]
            ]
        ]
    ],
];
