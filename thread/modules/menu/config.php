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
    'params' => [
        'format' => [
            'date' => 'd.m.Y',
            'time' => 'i:H',
        ]
    ],
];
