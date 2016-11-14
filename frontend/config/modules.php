<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    /**
     * CORE
     */
    'home' => [
        'class' => \frontend\modules\home\Home::class,
    ],
    'user' => [
        'class' => \frontend\modules\user\User::class,
    ],
    'menu' => [
        'class' => \frontend\modules\menu\Menu::class,
    ],
    'page' => [
        'class' => \frontend\modules\page\Page::class,
    ],
    'news' => [
        'class' => \frontend\modules\news\News::class,
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
    'shop' => [
        'class' => \frontend\modules\shop\Shop::class,
    ],
];
