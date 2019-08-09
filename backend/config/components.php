<?php

return [
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
        'cookieValidationKey' => \getenv('THREAD_COOKIE_VALIDATION_KEY'),
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
