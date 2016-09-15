<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    'params' => [
        'format' => [
            'date' => 'd.m.Y',
            'time' => 'i:H',
        ]
    ],

    //Migration
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => __DIR__ . '/migrations',
        ],
    ],

    'internal_sources' => [
        'page' => [
            'page' => [
                'label' => 'Page',
                'class' => \thread\modules\page\models\Page::class,
                'method' => 'dropDownList',
            ]
        ],
        'news' => [
            'group' => [
                'label' => 'News Group',
                'class' => \backend\modules\news\models\Group::class,
                'method' => 'dropDownList',
            ]
        ],
    ],
];
