<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
return [
    /**
     * CORE
     */
    'home' => [
        'class' => \frontend\modules\home\Home::class,
    ],
    'configs' => [
        'class' => \frontend\modules\configs\Configs::class,
    ],
    'user' => [
        'class' => \frontend\modules\user\User::class,
    ],
    'page' => [
        'class' => \frontend\modules\page\Page::class,
    ],
    'news' => [
        'class' => \frontend\modules\news\News::class,
    ],
    'forms' => [
        'class' => \frontend\modules\forms\Forms::class,
    ],
    'seo' => [
        'class' => \frontend\modules\seo\Seo::class,
        'objects' => [
            'page' => [
                'page' => [
                    'class' => \frontend\modules\page\models\Page::class,
                    'method' => 'find_base',
                ],
            ],
        ]
    ],
];
