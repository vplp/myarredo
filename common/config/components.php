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
        'loginUrl' => ['/user/login'],
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
        'enableCaching' => true,
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
            'hostname' => \getenv('REDIS_HOST'),
            'port' => \getenv('REDIS_PORT'),
            'database' => 0,
        ]
    ],
    'rc' => [
        'class' => \yii\redis\Cache::class,
        'redis' => [
            'hostname' => \getenv('REDIS_HOST'),
            'port' => \getenv('REDIS_PORT'),
            'database' => 1,
        ]
    ],
    'reCaptcha' => [
        'name' => 'reCaptcha',
        'class' => \himiklab\yii2\recaptcha\ReCaptchaConfig::class,
        'siteKeyV2' => \getenv('RECAPTCHA_SITE_KEY_V2'),
        'secretV2' => \getenv('RECAPTCHA_SECRET_V2'),
        'siteKeyV3' => \getenv('RECAPTCHA_SITE_KEY_V3'),
        'secretV3' => \getenv('RECAPTCHA_SECRET_V3'),
    ],
    'sendPulse' => [
        'class' => \common\components\sendpulse\SendPulse::class,
        'userId' => \getenv('SEND_PULSE_USER_ID'),
        'secret' => \getenv('SEND_PULSE_SECRET'),
    ],
    'param' => [
        'class' => \common\modules\sys\modules\configs\components\ConfigsParams::class,
    ],
    'elasticsearch' => [
        'class' => \yii\elasticsearch\Connection::class,
        'autodetectCluster' => false,
        'nodes' => [
            ['http_address' => \getenv('ELASTIC_SEARCH_HTTP_ADDRESS')],
        ],
    ],
    'yandexTranslation' => [
        'class' => \common\components\translation\YandexTranslation::class,
        'key' => \getenv('YANDEX_TRANSLATOR_KEY'),
        'folder_id' => \getenv('YANDEX_TRANSLATION_FOLDER_ID'),
        'service_account_id' => \getenv('YANDEX_TRANSLATION_SERVICE_ACCOUNT_ID'),
        'service_account_key_id' => \getenv('YANDEX_TRANSLATION_SERVICE_ACCOUNT_KEY_ID'),
    ],
    'yandexKassa' => [
        'class' => \common\components\YandexKassaAPI\YandexKassaAPI::class,
        'returnUrl' => 'https://www.myarredo.ru/',
        'shopId' => \getenv('YANDEX_KASSA_SHOP_ID'),
        'key' => \getenv('YANDEX_KASSA_KEY'),
    ],
    'robokassa' => [
        'class' => \common\components\robokassa\Merchant::class,
        'baseUrl' => 'https://auth.robokassa.ru/Merchant/Index.aspx',
        'sMerchantLogin' => 'MYARREDOFAMILY',
        'sMerchantPass1' => YII_DEBUG
            ? \getenv('ROBOKASSA_S_MERCHANT_PASS1_test')
            : \getenv('ROBOKASSA_S_MERCHANT_PASS1'),
        'sMerchantPass2' => YII_DEBUG
            ? \getenv('ROBOKASSA_S_MERCHANT_PASS2_TEST')
            : \getenv('ROBOKASSA_S_MERCHANT_PASS2'),
        'isTest' => YII_DEBUG,
    ]
];
