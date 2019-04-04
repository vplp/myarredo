<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $user User */
/* @var $password User['password'] */

$search = [
    '#first_name#',
    '#email#',
    '#password#',
    '#token#'
];

$token_url = Yii::$app->getRequest()->hostInfo .
    Url::toRoute([
        '/user/register/confirmation',
        'token' => $user['auth_key']
    ]);

$replace = [
    Html::encode($user['first_name']),
    $user['email'],
    $password,
    Html::a($token_url, $token_url)
];

echo str_replace($search, $replace, $text);
