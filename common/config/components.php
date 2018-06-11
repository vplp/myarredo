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
    // MAIL
    'mail-carrier' => [
        'class' => \thread\modules\sys\modules\mailcarrier\components\MailCarrier::class,
        'pathToLayout' => '@frontend/mail/layouts',
        'pathToViews' => '@frontend/mail/views',
    ],
    'mailer' => [
        'class' => \yii\swiftmailer\Mailer::class,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp-pulse.com',
            'username' => 'myarredo@mail.ru',
            'password' => 'ZYfKZWr29eB3',
            'port' => '465',
            'encryption' => 'ssl',
        ],
        'useFileTransport' => false,
        'enableSwiftMailerLogging' => true,
        'messageConfig' => [
            'charset' => 'UTF-8',
            'from' => ['info@myarredo.ru' => 'myarredo'],
        ],
    ],
    // FileCache
    'cache' => [
        'class' => \yii\caching\FileCache::class,
        'cachePath' => '@runtime',
        'keyPrefix' => 'thread'
    ],
    // MemCache
    'memCache' => [
        'class' => \yii\caching\MemCache::class,
        'servers' => [
            [
                'host' => 'localhost',
                'port' => 11211,
            ],
        ],
    ],
    // RedisCache
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
    // reCaptcha
    'reCaptcha' => [
        'name' => 'reCaptcha',
        'class' => \himiklab\yii2\recaptcha\ReCaptcha::class,
        'siteKey' => '6LehPRkUAAAAAB1TVTLbwB1GYua9tI4aC1cHYSTU',
        'secret' => '6LehPRkUAAAAADUIdKWBJx1tPKLztXMoVcsrHVrl',
    ],
    // sendPulse
    'sendPulse' => [
        'class' => \common\components\sendpulse\SendPulse::class,
        'userId' => '5a4017d2702c0caa55238646202925af',
        'secret' => 'b93e723419dbdf7a0be49143c702d804',
    ],
    // YandexTranslator
    'yandexTranslator' => [
        'class' => \common\components\YandexTranslator::class,
        'key' => 'trnsl.1.1.20180326T121847Z.97ead48fdb04534c.3713f3146271d3c8c47c8c97be8fae539ac776fd',
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
];
