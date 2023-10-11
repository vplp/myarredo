<?php

return [
    'gridview' => [
        'class' => \kartik\grid\Module::class,
    ],
    'sys' => [
        'class' => \backend\modules\sys\Sys::class,
    ],
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
    'news' => [
        'class' => \backend\modules\news\News::class,
    ],
    'articles' => [
        'class' => \backend\modules\articles\Articles::class,
    ],
    'seo' => [
        'class' => \backend\modules\seo\Seo::class,
    ],
    'location' => [
        'class' => \backend\modules\location\Location::class,
    ],
    'shop' => [
        'class' => \backend\modules\shop\Shop::class,
    ],
    'catalog' => [
        'class' => \backend\modules\catalog\Catalog::class
    ],
    'banner' => [
        'class' => \backend\modules\banner\BannerModule::class,
    ],
    'forms' => [
        'class' => \backend\modules\forms\FormsModule::class,
    ],
    'files' => [
        'class' => \backend\modules\files\FilesModule::class,
    ],
    'payment' => [
        'class' => \backend\modules\payment\PaymentModule::class,
    ],
    'rules' => [
        'class' => \backend\modules\rules\RulesModule::class,
    ],
    'promotion' => [
        'class' => \backend\modules\promotion\PromotionModule::class,
    ],
];
