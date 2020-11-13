<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require(dirname(__DIR__, 2) . '/common/config/main.php'), [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'runtimePath' => '@runtime/api',
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => require __DIR__ . '/bootstrap.php',
    'components' => require __DIR__ . '/components.php',
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => require __DIR__ . '/params.php',
]);
