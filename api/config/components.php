<?php

return [
    'request' => [
        'cookieValidationKey' => 'api',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
            'application/xml' => 'yii\web\XmlParser',
        ],
    ],
    'response' => [
        'formatters' => [
            'json' => [
                'class' => 'yii\web\JsonResponseFormatter',
                'prettyPrint' => YII_DEBUG,
                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
        ],
    ],
    'user' => [
        'identityClass' => 'api\modules\user\models\User',
        'enableAutoLogin' => true,
        'enableSession' => false,
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'enableStrictParsing' => true,
        'showScriptName' => false,
        'rules' => require __DIR__ . '/part/url-rules.php',
    ]
];
