<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
//    'session' => [
//        'class' => \yii\web\DbSession::class,
//        Set the following if you want to use DB component other than
//        'db' => 'coredb',
//            To override default session table, set the following
//        'sessionTable' => 'fv_session',
    /*
      CREATE TABLE fv_session (
      id CHAR(40) NOT NULL PRIMARY KEY,
      expire INTEGER,
      data BLOB
      )
     */
//    ],
    'user' => [
        'class' => \yii\web\User::class,
        'identityClass' => \thread\modules\user\models\User::class,
        'enableAutoLogin' => false,
        'loginUrl' => ['/user/login']
    ],
    'view' => [
        'class' => \yii\web\View::class,
        'renderers' => [
            'mustache' => \yii\mustache\ViewRenderer::class
        ]
    ]
];
