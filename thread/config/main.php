<?php

use yii\helpers\ArrayHelper;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
//DEFINE SECTION
require(__DIR__ . '/alias.php');

$vendor = Yii::getAlias('@vendor');

return [
    'vendorPath' => $vendor,
    'sourceLanguage' => 'en-EN',
    'language' => 'en-EN',
    'charset' => 'utf-8',
    'extensions' => require($vendor . '/yiisoft/extensions.php'),
    'params' => require __DIR__ . '/params.php',
    'bootstrap' => [
        'languages'
    ],
    'components' => ArrayHelper::merge(
        require(__DIR__ . '/components.php'), require(__DIR__ . '/db.php')
    ),
];
