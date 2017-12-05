<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    // FileCache
    'cache' => [
        'class' => \yii\caching\FileCache::class,
        'cachePath' => '@runtime',
        'keyPrefix' => 'backend'
    ],
    'languages' => [
        'class' => \thread\app\model\Languages::class,
        'languageModel' => \backend\modules\sys\models\Language::class,
    ],
    'user' => [
        'enableAutoLogin' => true,
    ],
    'i18n' => [
        'class' => \thread\app\base\i18n\I18N::class,
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
    'mailer' => [
        'class' => \yii\swiftmailer\Mailer::class,
        'viewPath' => '@backend/mail',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => true,
    ],
    'view' => [
        'theme' => [
            'baseUrl' => '@web/themes/defaults',
            'pathMap' => [
                '@app/layouts' => [
                    '@app/themes/defaults/layouts',
                ],
                '@app/modules' => [
                    '@app/themes/defaults/layouts',
                ]
            ],
        ],
    ],
];
