<?php

return [
    'languages' => [
        'class' => \thread\app\model\Languages::class,
        'languageModel' => \common\modules\sys\models\Language::class,
    ],
    'user' => [
        'class' => \yii\web\User::class,
        'identityClass' => \common\modules\user\models\User::class,
        'enableAutoLogin' => false,
        'loginUrl' => ['/user/login']
    ],
    'view' => [
        'class' => \yii\web\View::class,
        'renderers' => [
            'mustache' => \yii\mustache\ViewRenderer::class
        ]
    ],
    'i18n' => [
        'class' => \thread\modules\sys\modules\translation\components\I18N::class,
        'languageModel' => \common\modules\sys\models\Language::class,
        'enableCaching' => false,
        'cachingDuration' => 3600
    ],
    'shop_cart' => [
        'class' => \common\modules\shop\components\Cart::class,
        'threadProductClass' => \common\modules\catalog\models\Product::class,
        'frontendProductClass' => \frontend\modules\catalog\models\Product::class
    ],
    'mail-carrier' => [
        'class' => \thread\modules\sys\modules\mailcarrier\components\MailCarrier::class,
        'pathToLayout' => '@frontend/mail/layouts',
        'pathToViews' => '@frontend/mail/views',
    ],
    'cache' => [
        'class' => \yii\caching\FileCache::class,
        'cachePath' => '@runtime',
        'keyPrefix' => 'thread'
    ],
    'memCache' => [
        'class' => \yii\caching\MemCache::class,
        'servers' => [
            [
                'host' => 'localhost',
                'port' => 11211,
            ],
        ],
    ],
    'redisCache' => [
        'class' => \yii\redis\Cache::class,
        'redis' => [
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ]
    ],
    'rc' => [
        'class' => \yii\redis\Cache::class,
        'redis' => [
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 1,
        ]
    ],
    'reCaptcha' => [
        'class' => \himiklab\yii2\recaptcha\ReCaptchaConfig::class,
        'siteKeyV3' => '6LehRIoUAAAAALWGhlNNdb7hmXiK8NTju_tl2LXl',
        'secretV3' => '6LehRIoUAAAAAKfN2eFDO7nR7xmLE8bCJQMRlPyk',
    ],
    'sendPulse' => [
        'class' => \common\components\sendpulse\SendPulse::class,
        'userId' => '5a4017d2702c0caa55238646202925af',
        'secret' => 'b93e723419dbdf7a0be49143c702d804',
    ],
    'param' => [
        'class' => \common\modules\sys\modules\configs\components\ConfigsParams::class,
    ],
    'elasticsearch' => [
        'class' => \yii\elasticsearch\Connection::class,
        'autodetectCluster' => false,
        'nodes' => [
            ['http_address' => 'localhost:9200'],
        ],
    ],
    'yandexTranslator' => [
        'class' => \common\components\YandexTranslator::class,
        'key' => 'trnsl.1.1.20180326T121847Z.97ead48fdb04534c.3713f3146271d3c8c47c8c97be8fae539ac776fd',
    ],
    'yandexKassa' => [
        'class' => \common\components\YandexKassaAPI\YandexKassaAPI::class,
        'returnUrl' => 'https://www.myarredo.ru/',
        'shopId' => '518473', //'519736',
        'key' => 'live_LFY41_Fv20kbUCvAYMS66r3q6aS4r78MX3u2NU7C8To',
        //'key' => 'test_PHsoZmISCHfA5FjC6bcUPWyxDSCBS-s6YgQrKMV7TYA',
    ],
    'robokassa' => [
        'class' => \common\components\robokassa\Merchant::class,
        'baseUrl' => 'https://auth.robokassa.ru/Merchant/Index.aspx',
        'sMerchantLogin' => 'MYARREDOFAMILY',
        'sMerchantPass1' => YII_DEBUG ? 'test_E8Sl6Pwc1EOqVO2QJh7T' : 'o3RIgyHzCzV9Y4rdR5k2',
        'sMerchantPass2' => YII_DEBUG ? 'test_XfgDyHnd1P6bfxB91QO5' : 'R69VO6fXmuhfmPfQ5V6Y',
        'isTest' => YII_DEBUG,
    ]
];
