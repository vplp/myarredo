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
        'suffix' => '/',
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
        //'class' => \thread\app\web\View::class,
        'theme' => [
            'basePath' => '@app/themes/myarredo',
            'baseUrl' => '@web/themes/myarredo',
            'pathMap' => [
                '@app/layouts' => '@app/themes/myarredo/layouts',
            ],
        ],
    ],
    'i18n' => [
        'class' => \thread\app\base\i18n\I18N::class,
    ],
    'catalogFilter' => [
        'class' => \frontend\modules\catalog\components\CatalogFilter::class,
    ],
    'city' => [
        'class' => \frontend\modules\location\components\CityComponent::class,
    ],
    'partner' => [
        'class' => \frontend\modules\user\components\PartnerComponent::class,
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
    'metatag' => [
        'class' => \frontend\modules\seo\components\MetaTag::class
    ],
];
