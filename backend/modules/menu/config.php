<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

return [
    'internal_sources' => [
        'page' => [
            'page' => [
                'label' => 'Page',
                'class' => \backend\modules\page\models\Page::class,
                'method' => 'dropDownList',
            ]
        ],
        'faq' => [
            'group' => [
                'label' => 'Faq Group',
                'class' => \backend\modules\news\models\Group::class,
                'method' => 'dropDownList',
            ]
        ],
    ],
    'permanent_link' => [
        '/home/home/index' => 'Главная',
        '/catalog/category/list' => 'Каталог мебели',
        '/catalog/sale/list' => 'Распродажа',
        '/catalog/sale-italy/list' => 'Распродажа в Италии',
        '/catalog/factory/list' => 'Фабрики',
        '/user/register/partner' => 'Регистрация партнера',
        '/page/contacts/index' => 'Контакты',
        '/page/contacts/list-partners' => 'Наши партнеры',
        '/seo/sitemap-html/index' => 'Карта сайта',
    ]
];
