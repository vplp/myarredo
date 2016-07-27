<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
return [
    'user' => [
        'enableAutoLogin' => false,
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
    'view' => [
        'theme' => [
            'basePath' => '@app/themes/inspinia',
            'baseUrl' => '@web/themes/inspinia',
            'pathMap' => [
                '@app/layouts' => '@app/themes/inspinia/layouts',
            ],
        ],
    ],
];
