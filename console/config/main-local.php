<?php

return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => \yii\gii\Module::class,
    ],
    'components' => [
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp-pulse.com',
                'username' => 'myarredo@mail.ru',
                'password' => 'ZYfKZWr29eB3',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'useFileTransport' => false,
            'enableSwiftMailerLogging' => true,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['info@myarredo.ru' => 'myarredo'],
            ],
        ]
    ]
];
