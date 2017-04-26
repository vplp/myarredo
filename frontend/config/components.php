<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, Thread
 */
return [
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
            'basePath' => '@app/themes/defaults',
            'baseUrl' => '@web/themes/defaults',
            'pathMap' => [
                '@app/layouts' => '@app/themes/defaults/layouts',
            ],
        ],
    ],
];
