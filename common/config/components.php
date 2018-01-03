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
    //MAIL
    'mail-carrier' => [
        'class' => \thread\modules\sys\modules\mailcarrier\components\MailCarrier::class,
        'pathToLayout' => '@frontend/mail/layouts',
        'pathToViews' => '@frontend/mail/views',
    ],
    'mailer' => [
        'class' => \yii\swiftmailer\Mailer::class,
        'useFileTransport' => false,
        'enableSwiftMailerLogging' => true,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
        ],
    ],
/*
    'redis' => [
        'class' => \yii\redis\Connection::class,
        'hostname' => 'localhost',
        'port' => 6379,
        'database' => 0,
    ],
*/
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
        'secret' => '_reCaptcha_SECRET',
    ],
];
