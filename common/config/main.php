<?php

use yii\helpers\ArrayHelper;

// DEFINE SECTION
require(__DIR__ . '/alias.php');

return ArrayHelper::merge(
    require(dirname(__DIR__, 2) . '/thread/config/main.php'),
    [
        'name' => 'MY ARREDO FAMILY',
        'sourceLanguage' => 'ru-RU',
        'language' => 'ru-RU',
        'components' => ArrayHelper::merge(
            require(__DIR__ . '/components.php'),
            require(__DIR__ . '/db.php')
        ),
        'modules' => require(__DIR__ . '/modules.php')
    ]
);
