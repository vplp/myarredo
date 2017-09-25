<?php

return [
    'languages' => [
        'class' => \thread\app\model\Languages::class,
        'languageModel' => \thread\modules\sys\models\Language::class,
    ],
    'user' => [
        'class' => \yii\web\User::class,
        'identityClass' => \thread\modules\user\models\User::class,
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
        'languageModel' => \thread\modules\sys\models\Language::class,
        'enableCaching' => false,
        'cachingDuration' => 3600
    ],
    'shop_cart' => [
        'class' => \thread\modules\shop\components\Cart::class,
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
];
