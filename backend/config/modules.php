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
     * SYSTEM
     */
    'sys' => [
        'class' => \backend\modules\sys\Sys::class,
    ],
    /**
     * CORE
     */
    'home' => [
        'class' => \backend\modules\home\Home::class,
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
//    'news' => [
//        'class' => \backend\modules\news\News::class,
//    ],
    'seo' => [
        'class' => \backend\modules\seo\Seo::class,
    ],
    'location' => [
        'class' => \backend\modules\location\Location::class,
    ],
//    'polls' => [
//        'class' => \backend\modules\polls\Polls::class,
//    ],
//    'correspondence' => [
//        'class' => \backend\modules\correspondence\Correspondence::class,
//    ],
//    'shop' => [
//        'class' => \backend\modules\shop\Shop::class,
//    ],
    'translation' => [
        'class' => \backend\modules\sys\modules\translation\Translation::class
    ],
//    'feedback' => [
//        'class' => \backend\modules\feedback\Feedback::class
//    ],
    'catalog' => [
        'class' => \backend\modules\catalog\Catalog::class
    ],
];
