<?php

use yii\helpers\ArrayHelper;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return ArrayHelper::merge(ArrayHelper::merge(require(dirname(__DIR__, 2) . '/common/config/main.php'), [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'runtimePath' => '@runtime/backend',
    'layoutPath' => '@app/layouts',
    'sourceLanguage' =>'de-AT',
    'bootstrap' => require __DIR__ . '/bootstrap.php',
    'components' => require __DIR__ . '/components.php',
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => require __DIR__ . '/params.php',
]), require __DIR__ . '/main-local.php'
);
