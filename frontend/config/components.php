<?php

return [
    'languages' => [
        'class' => \thread\app\model\Languages::class,
        'languageModel' => \frontend\modules\sys\models\Language::class,
    ],
    'user' => [
        'enableAutoLogin' => false,
    ],
    'urlManager' => [
        'rules' => require __DIR__ . '/part/url-rules.php',
    ],
    'errorHandler' => [
        'errorAction' => 'home/home/error',
    ],
    'request' => [
        'class' => \thread\app\web\Request::class,
        'enableCsrfValidation' => true,
        'enableCookieValidation' => true,
        'cookieValidationKey' => 'thread',
    ],
    'view' => [
        'class' => \thread\app\web\View::class,
        'theme' => [
            'basePath' => '@app/themes/myarredo',
            'baseUrl' => '@web/themes/myarredo',
            'pathMap' => [
                '@app/layouts' => '@app/themes/myarredo/layouts',
            ],
        ],
    ],
    'catalogFilter' => [
        'class' => \frontend\modules\catalog\components\CatalogFilter::class,
    ],
    'mailer' => [
        'class' => \yii\swiftmailer\Mailer::class,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'mail.itsfera.com.ua',
            'username' => 'test@vipdesign.com.ua',
            'password' => 'iesh1eeXuiqu',
            'port' => '465',
            'encryption' => 'ssl',
        ],
        'useFileTransport' => false,
        'messageConfig' => [
            'charset' => 'UTF-8',
            'from' => ['test@vipdesign.com.ua' => 'myarredo'],
        ],
    ],
];
