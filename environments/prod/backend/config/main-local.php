<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
$components = [];

if (YII_ENV_DEV) {
    $components = [
        'bootstrap' => [
            'debug',
            'gii',
            'log'
        ],
        'modules' => [
            'debug' => \yii\debug\Module::class,
            'gii' => \yii\gii\Module::class,
        ],
        'components' => [
            'assetManager' => [
                //Використовуємо для постійного оновлення assets
                //потрібно для верстальника
                //обовязково очистити директорію /frontend/assets
                'linkAssets' => true
            ],
            'log' => [
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets' => [
                    [
                        'class' => \yii\log\FileTarget::class,
                        'levels' => ['error', 'warning'],
                    ],
                ],
            ],
        ],
    ];
}

return $components;