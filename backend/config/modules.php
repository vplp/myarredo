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
        'class' => backend\modules\home\Home::class,
    ],
    'page' => [
        'class' => backend\modules\page\Page::class,
    ],
    'news' => [
        'class' => backend\modules\news\News::class,
    ],
    'user' => [
        'class' => backend\modules\user\User::class,
    ],
    'seo' => [
        'class' => backend\modules\seo\Seo::class,
    ],
    'location' => [
        'class' => backend\modules\location\Location::class,
    ],
    'menu' => [
        'class' => backend\modules\menu\Menu::class,
    ],
    'forms' => [
        'class' => backend\modules\forms\Forms::class,
    ],
];
