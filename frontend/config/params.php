<?php

//Yii::$app->params['cache']['duration']

return [
    'mailer' => [
        'setFrom' => 'info@myarredo.ru',
        'setTo' => 'myarredo@myarredo.ru'
    ],
    'form_feedback' => [
        'setFrom' => 'info@myarredo.ru',
        'setTo' => 'help@myarredo.ru'
    ],
    'cache' => [
        'duration' => 60 * 60 * 2
    ]
];
