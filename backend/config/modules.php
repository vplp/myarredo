<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    /**
     * COMPONENTS
     */
    'gridview' => [
        'class' => \kartik\grid\Module::class,
    ],
    /**
     * CORE
     */
    'home' => [
        'class' => \backend\modules\home\Home::class,
    ],
    'configs' => [
        'class' => \backend\modules\configs\Configs::class,
    ],
    'user' => [
        'class' => \backend\modules\user\User::class,
    ],
    'menu' => [
        'class' => \backend\modules\menu\Menu::class,
    ],
    'page' => [
        'class' => \backend\modules\page\Page::class,
    ],
    'news' => [
        'class' => \backend\modules\news\News::class,
    ],
    'seo' => [
        'class' => \backend\modules\seo\Seo::class,
    ],
    'location' => [
        'class' => \backend\modules\location\Location::class,
    ],
    /**
     *
     */
];
