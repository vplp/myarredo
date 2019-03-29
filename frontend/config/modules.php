<?php

return [
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
    'articles' => [
        'class' => \frontend\modules\articles\Articles::class,
    ],
    'seo' => [
        'class' => \frontend\modules\seo\Seo::class,
        'objects' => [
            'page' => [
                'page' => [
                    'class' => \frontend\modules\page\models\Page::class,
                    'method' => 'findBase',
                ],
            ],
        ]
    ],
    'shop' => [
        'class' => \frontend\modules\shop\Shop::class,
    ],
    'feedback' => [
        'class' => \frontend\modules\feedback\Feedback::class,
    ],
    'catalog' => [
        'class' => \frontend\modules\catalog\Catalog::class,
    ],
    'location' => [
        'class' => \frontend\modules\location\Location::class,
    ],
    'banner' => [
        'class' => \frontend\modules\banner\Banner::class,
    ],
    'forms' => [
        'class' => \frontend\modules\forms\Forms::class,
    ],
    'payment' => [
        'class' => \frontend\modules\payment\PaymentModule::class,
    ],
    'gridview' => [
        'class' => \kartik\grid\Module::class
    ]
];
